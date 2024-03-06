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
use App\Entity\PdfGeneratorService;

#[Route('/backoffice/vols')]
class VolsController extends AbstractController
{
    #[Route('/', name: 'app_vols_index', methods: ['GET'])]
    public function index(VolsRepository $volsRepository, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            // Handle AJAX request for sorting
            $column = $request->query->get('column', 'id'); // Default column to sort by
            $direction = $request->query->get('direction', 'asc');

            // Debugging statement to check sorting parameters
            // dd([$column => $direction]);

            $vols = $volsRepository->findBy([], [$column => $direction]);

            // Debugging statement to check sorted data
            // dd($vols);

            return $this->json(['vols' => $vols]);
        }

        // Regular rendering for non-AJAX requests
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


    #[Route('/pdf/vol', name: 'generator_service')]
    public function pdfEvenement(): Response
    {
        $vol= $this->getDoctrine()
            ->getRepository(Vols::class)
            ->findAll();



        $html =$this->renderView('backoffice/vpdf/index.html.twig', ['vols' => $vol]);
        $pdfGeneratorService=new PdfGeneratorService();
        $pdf = $pdfGeneratorService->generatePdf($html);

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);

    }




}