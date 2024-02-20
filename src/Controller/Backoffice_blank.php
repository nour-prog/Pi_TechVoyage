<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use  App\Repository\OffresRepository;
class Backoffice_blank extends AbstractController
{
    #[Route('/backoffice/blank', name: 'app_backoffice_blank')]
    public function index(OffresRepository $offresRepository): Response
    {
        return $this->render('backoffice/blank/index.html.twig',[
            "table" =>$offresRepository->findAll()
        ]);
    }
}
