<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Offres;
use App\Repository\OffresRepository;

class APIOfferReviewController extends AbstractController
{
    #[Route('/api/offer/addreview', methods: ['POST'])]
    public function index(Request $request, OffresRepository $offresRepository): JsonResponse
    {
        $userId = $request->request->get("userid");
        $reviewValue = $request->request->get("value");
        $offreId = $request->request->get("offreid");

        // Find the offer by its ID
        $offre = $offresRepository->find($offreId);

        // Check if the offer exists
        if (!$offre) {
            return new JsonResponse(['error' => 'Offer not found'], 404);
        }
        $entityManager = $this->getDoctrine()->getManager();
        // Add the review to the offer
        $offre->addReview($userId, $reviewValue,$entityManager);

        // Persist the updated offer entity
     
        $entityManager->persist($offre);
        $entityManager->flush();
       
        return new JsonResponse(['message' => 'Success']);
    }
}
