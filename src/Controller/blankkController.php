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

class blankkController extends AbstractController
{

#[Route('/frontoffice/volspromo', name: 'app_blankk')]
public function indexpromo(PromoVolsRepository  $PromoVolsRepository): Response
{

return $this->render('frontoffice/blank/volpromo.html.twig', [
'promo_vols' => $PromoVolsRepository->findAll(),
]);



}



}