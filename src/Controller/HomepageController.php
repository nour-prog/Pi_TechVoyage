<?php

namespace App\Controller;
use  App\Repository\OffresRepository;
use  App\Repository\OffreCommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(OffresRepository $offresRepository): Response
    {      
        return $this->render('frontoffice/homepage/index.html.twig',[
            "table" =>$offresRepository->findAll()
        ]);
    }





}
