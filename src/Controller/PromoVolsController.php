<?php

namespace App\Controller;

use App\Entity\PromoVols;
use App\Form\PromoVolsType;
use App\Repository\PromoVolsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('backoffice/promo/vols')]
class PromoVolsController extends AbstractController
{
    #[Route('/', name: 'app_promo_vols_index', methods: ['GET'])]
    public function index(PromoVolsRepository $promoVolsRepository): Response
    {
        return $this->render('promo_vols/index.html.twig', [
            'promo_vols' => $promoVolsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_promo_vols_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $promoVol = new PromoVols();
        $form = $this->createForm(PromoVolsType::class, $promoVol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($promoVol);
            $entityManager->flush();

            return $this->redirectToRoute('app_promo_vols_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promo_vols/new.html.twig', [
            'promo_vol' => $promoVol,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_promo_vols_show', methods: ['GET'])]
    public function show(PromoVols $promoVol): Response
    {
        return $this->render('promo_vols/show.html.twig', [
            'promo_vol' => $promoVol,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_promo_vols_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PromoVols $promoVol, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PromoVolsType::class, $promoVol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_promo_vols_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promo_vols/edit.html.twig', [
            'promo_vol' => $promoVol,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_promo_vols_delete', methods: ['POST'])]
    public function delete(Request $request, PromoVols $promoVol, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$promoVol->getId(), $request->request->get('_token'))) {
            $entityManager->remove($promoVol);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_promo_vols_index', [], Response::HTTP_SEE_OTHER);
    }
}
