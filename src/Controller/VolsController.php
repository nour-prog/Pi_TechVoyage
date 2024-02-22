<?php

namespace App\Controller;

use App\Entity\Vols;
use App\Form\VolsType;
use App\Repository\VolsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backoffice/vols')]
class VolsController extends AbstractController
{
    #[Route('/', name: 'app_vols_index', methods: ['GET'])]
    public function index(VolsRepository $volsRepository): Response
    {
        return $this->render('vols/index.html.twig', [
            'vols' => $volsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vols_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vol = new Vols();
        $form = $this->createForm(VolsType::class, $vol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vol);
            $entityManager->flush();

            return $this->redirectToRoute('app_vols_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vols/new.html.twig', [
            'vol' => $vol,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vols_show', methods: ['GET'])]
    public function show(Vols $vol): Response
    {
        return $this->render('vols/show.html.twig', [
            'vol' => $vol,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vols_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vols $vol, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VolsType::class, $vol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vols_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vols/edit.html.twig', [
            'vol' => $vol,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vols_delete', methods: ['POST'])]
    public function delete(Request $request, Vols $vol, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vol->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vol);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vols_index', [], Response::HTTP_SEE_OTHER);
    }
}
