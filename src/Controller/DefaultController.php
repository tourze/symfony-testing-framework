<?php

namespace SymfonyTestingFramework\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DefaultController extends AbstractController
{
    #[Route(path: '/', name: 'homepage')]
    public function index(): Response
    {
        return $this->redirectToRoute('admin');
    }
}
