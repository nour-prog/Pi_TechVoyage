<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use  App\Repository\OffreCommentaireRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use  App\Repository\OffresRepository;
class Backoffice_blank extends AbstractController
{
    #[Route('/backoffice/reservation', name: 'app_backoffice_blank')]
    public function index(): Response
    {
        return $this->render('backoffice/dashboard/index.html.twig');
    }
    
    
    #[Route('/backoffice/blank', name: 'app_backoffice_blankOffres')]
    public function indexOffres(OffresRepository $offresRepository): Response
    {
        return $this->render('backoffice/blank/offres.html.twig',[
            "table" =>$offresRepository->findAll()
        ]);
    }
    #[Route('/show/commentaireb', name: 'app_affichecommentaireb')]
    public function affichecommentaireb(OffreCommentaireRepository $offrecommentaireRepository): Response
    {      
        return $this->render('backoffice/blank/show.html.twig',[
            "commentaires" =>$offrecommentaireRepository->findAll()
        ]);
    }


}
