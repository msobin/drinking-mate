<?php

namespace App\Tests\Api\v1;

use App\Entity\Mate;
use App\Infrastructure\Point\Point;
use App\Infrastructure\Uuid\Uuid;
use App\Repository\MateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class MatesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ContainerInterface $container;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->container = $this->getContainer();
    }

    public function testWannaDrink()
    {
        $name = 'name';
        $description = 'description';
        $latitude = 51.132176;
        $longitude = 71.42186;

        $response = $this->createMate($name, $description, $latitude, $longitude);

        $this->assertResponseIsSuccessful();

        /** @var JWTTokenManagerInterface $jwtManager */
        $jwtManager = $this->container->get(JWTTokenManagerInterface::class);

        $parsedToken = $jwtManager->parse($this->getToken($response));

        /** @var MateRepository $mateRepository */
        $mateRepository = $this->container->get(MateRepository::class);
        $mate = $mateRepository->find($parsedToken['username']);

        $this->assertNotNull($mate);
        $this->assertEquals($name, $mate->getName());
        $this->assertEquals($description, $mate->getDescription());
        $this->assertEquals("SRID=4326;POINT($longitude $latitude)", $mate->getPoint());
    }

    public function testGetNearBy()
    {
        /** @var EntityManagerInterface $em */
        $em = $this->container->get(EntityManagerInterface::class);

        $response = $this->createMate('name1', 'description1', 51.133214, 71.420884);
        $token = $this->getToken($response);

        $id1 = Uuid::v7();
        $id2 = Uuid::v7();
        $id3 = Uuid::v7();

        $em->persist(
            (new Mate())
                ->setId($id1)
                ->setName('name2')
                ->setDescription('description2')
                ->setPoint(Point::fromCoordinates( 51.13324, 71.419642))
        );

        $em->persist(
            (new Mate())
                ->setId($id2)
                ->setName('name3')
                ->setDescription('description3')
                ->setPoint(Point::fromCoordinates( 51.132798, 71.421205)));

        $em->persist(
            (new Mate())
                ->setId($id3)
                ->setName('name4')
                ->setDescription('description4')
                ->setPoint(Point::fromCoordinates( 51.147655, 71.418771))
        );

        $em->flush();

        $this->client->request('GET', '/api/v1/mates/nearby', [], [], ['HTTP_Authorization' => "Bearer $token"]);
        $response = $this->client->getResponse();

        $mates = json_decode($response->getContent(), true);
        $ids = array_map(fn($mate) => $mate['id'], $mates);

        $this->assertContains($id1->toString(), $ids);
        $this->assertContains($id2->toString(), $ids);
        $this->assertNotContains($id3->toString(), $ids);
    }

    private function createMate(string $name, string $description, float $latitude, float $longitude): JsonResponse
    {
        $this->client->request(
            'POST',
            '/api/v1/wanna-drink',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                    'name' => $name,
                    'description' => $description,
                    'latitude' => $latitude,
                    'longitude' => $longitude
                ])
        );

        return $this->client->getResponse();
    }

    private function getToken(JsonResponse $response): string
    {
        $content = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('token', $content);

        return $content['token'];
    }
}
