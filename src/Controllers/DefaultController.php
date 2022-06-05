<?php

namespace App\Controllers;

use Luhmm1\ViaRouter\Attributes\Route;
use Psr\Http\Message\ResponseInterface;

class DefaultController extends AbstractController
{
    #[Route('/[{name}]')]
    public function index(?string $name): ResponseInterface
    {
        return $this->render('pages/homepage.twig', [
            'name' => $name
        ]);
    }
}
