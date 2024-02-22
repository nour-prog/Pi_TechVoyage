<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Vols;
use App\Form\VolsType;
use App\Repository\VolsRepository;
use App\Repository\PromoVolsRepository;
use Doctrine\ORM\EntityManagerInterface;

class BlankController extends AbstractController
{
    #[Route('/frontoffice/vols', name: 'app_blank')]
    public function index(VolsRepository $volsRepository): Response
    {

        return $this->render('frontoffice/blank/index.html.twig', [
            'vols' => $volsRepository->findAll(),
        ]);



    }










}
