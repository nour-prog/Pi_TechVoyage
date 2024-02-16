<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlankController extends AbstractController
{
    #[Route('/blank22', name: 'app_blank')]
    public function index(): Response
    {
        return $this->render('frontoffice/blank/index.html.twig');
    }
}
