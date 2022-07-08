<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index', env: 'dev')]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'now' => new \DateTimeImmutable(),
        ]);
    }

    #[Route('/status', name: 'app_status', env: 'dev')]
    public function status(): Response
    {
        return new JsonResponse(['status' => 'ok']);
    }
}
