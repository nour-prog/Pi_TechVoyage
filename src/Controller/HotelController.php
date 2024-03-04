<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\Hotel1Type;
use App\Service\PerspectiveAPIService;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/hotel')]
class HotelController extends AbstractController
{



    #[Route('/bad', name: 'badavis', methods: ['POST'])]
    public function submitAvis(Request $request, PerspectiveAPIService $perspectiveAPIService): JsonResponse
    {
        $avis = $request->request->get('avis');

        // List of bad words
        $badWords = ["tue", "merde", "pute", "gueule", "débile", "con", "abruti", "clochard", "sang"];

        // Check if the avis contains any bad words
        foreach ($badWords as $badWord) {
            if (stripos($avis, $badWord) !== false) {
                // Bad word detected, return a JSON response indicating the issue
                return $this->json(['error' => 'Content contains inappropriate language.'], JsonResponse::HTTP_BAD_REQUEST);
            }
        }

        // Continue with your existing code to analyze content with Perspective API
        $perspectiveResult = $perspectiveAPIService->analyzeContent($avis);

        if ($perspectiveResult['attributeScores']['TOXICITY']['summaryScore']['value'] > 0.7) {
            // Traitement en cas de contenu potentiellement toxique détecté
            // Retourner une réponse appropriée, rediriger ou afficher un message d'erreur
            return $this->json(['error' => 'Content is potentially toxic.'], JsonResponse::HTTP_BAD_REQUEST);
        } else {
            // Aucun contenu potentiellement toxique détecté, enregistrez l'avis ou effectuez d'autres actions
            // Retourner une réponse appropriée, rediriger ou afficher un message de succès
            return $this->json(['success' => 'Avis submitted successfully.'], JsonResponse::HTTP_OK);
        }
    }

   //
    #[Route('/index1', name: 'app_hotel_index', methods: ['GET'])]
    public function listeHotels(EntityManagerInterface $entityManager) :Response
    {
        // Récupérez les hôtels triés par le nombre d'étoiles
        $hotels = $entityManager->getRepository(Hotel::class)
            ->createQueryBuilder('u')
            ->orderBy('u.nbretoile','ASC') // Changez 'ASC' à 'DESC' si vous voulez trier par ordre décroissant
            ->getQuery()
            ->getResult();

        // Passez la liste triée à votre template Twig
        return $this->render('frontoffice/hotel/index1.html.twig', ['hotels' => $hotels]);
    }
    #[Route('/', name: 'app_hotel_index', methods: ['GET'])]
    public function index(HotelRepository $hotelRepository): Response
    {
        return $this->render('frontoffice/hotel/index1.html.twig', [
            'hotels' => $hotelRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_hotel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hotel = new Hotel();
        $form = $this->createForm(Hotel1Type::class, $hotel);
        $form->handleRequest($request);

        $myDictionary = array(
            "tue", "merde", "pute",
            "gueule",
            "débile",
            "con",
            "abruti",
            "clochard",
            "sang"
        );


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hotel);
            $entityManager->flush();
            flash()->addSuccess('Votre Hotel est ajouter avec succés');

            return $this->redirectToRoute('app_hotel_index', [], Response::HTTP_SEE_OTHER);

        }

        return $this->renderForm('backoffice/new1.html.twig', [
            'hotel' => $hotel,
            'form' => $form,

        ]);
    }

    #[Route('/{id}', name: 'app_hotel_show', methods: ['GET'])]
    public function show(Hotel $hotel): Response
    {
        return $this->render('frontoffice/hotel/show1.html.twig', [
            'hotel' => $hotel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hotel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hotel $hotel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Hotel1Type::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            flash()->addSuccess('Votre Hotel est Modifier avec succés');

            return $this->redirectToRoute('app_hotel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('frontoffice/hotel/edit1.html.twig', [
            'hotel' => $hotel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hotel_delete', methods: ['POST'])]
    public function delete(Request $request, Hotel $hotel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hotel->getId(), $request->request->get('_token'))) {
            $entityManager->remove($hotel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hotel_index', [], Response::HTTP_SEE_OTHER);
    }

}
