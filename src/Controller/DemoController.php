<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

final class DemoController extends AbstractController
{
    #[Route('/demo/', name: 'test_client', methods: ['GET'])]
    #[Template('demo/index.html.twig')]
    public function testClient(): array
    {
        return [];
    }
}
