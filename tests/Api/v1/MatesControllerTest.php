<?php

namespace App\Tests\Api\v1;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Entity\Mate;
use App\Infrastructure\Uuid\Uuid;
use App\Repository\MateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class MatesControllerTest extends ApiTestCase
{
    private Client $client;
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
                ->setPoint('SRID=4326;POINT(71.419642 51.13324)')
        );

        $em->persist(
            (new Mate())
                ->setId($id2)
                ->setName('name3')
                ->setDescription('description3')
                ->setPoint('SRID=4326;POINT(71.421205 51.132798)')
        );

        $em->persist(
            (new Mate())
                ->setId($id3)
                ->setName('name4')
                ->setDescription('description4')
                ->setPoint('SRID=4326;POINT(71.418771 51.147655)')
        );

        $em->flush();

        $client = static::createClient([], ['headers' => ['Authorization' => 'Bearer ' . $token]]);
        $response = $client->request('GET', '/api/v1/mates/nearby');

        $mates = json_decode($response->getContent(), true);
        $ids = array_map(fn($mate) => $mate['id'], $mates);

        $this->assertContains($id1->toString(), $ids);
        $this->assertContains($id2->toString(), $ids);
        $this->assertNotContains($id3->toString(), $ids);
    }

    private function createMate(string $name, string $description, float $latitude, float $longitude): ResponseInterface
    {
        return $this->client->request('POST', '/api/v1/wanna-drink', [
            'json' => [
                'name' => $name,
                'description' => $description,
                'latitude' => $latitude,
                'longitude' => $longitude
            ]
        ]);
    }

    private function getToken(ResponseInterface $response): string
    {
        $content = $response->toArray();

        $this->assertArrayHasKey('token', $content);

        return $content['token'];
    }
}
