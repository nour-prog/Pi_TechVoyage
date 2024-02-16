<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Backoffice_blank extends AbstractController
{
    #[Route('/backoffice/reservation', name: 'app_backoffice_blank')]
    public function index(): Response
    {
        return $this->render('backoffice/dashboard/index.html.twig');
    }
}
