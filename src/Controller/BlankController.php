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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\CountryInfoService;

use Symfony\Component\HttpClient\HttpClient;

class BlankController extends AbstractController
{
    #[Route('/frontoffice/vols', name: 'app_blank')]
    public function index(VolsRepository $volsRepository): Response
    {
        return $this->render('frontoffice/blank/index.html.twig', [
            'vols' => $volsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/search", name="search_action", methods={"POST"})
     */
    public function searchAction(Request $request, VolsRepository $volsRepository)
    {
        $searchQuery = $request->request->get('query');

        // Perform your search logic using $searchQuery
        $searchResults = $volsRepository->findByKeyword($searchQuery);

        // Transform results into an array suitable for JSON response
        $formattedResults = [];
        foreach ($searchResults as $result) {
            $formattedResults[] = [
                'pointdepart' => $result->getPointDepart(),
                'destination' => $result->getDestination(),
                'duree' => $result->getDuree() ? $result->getDuree()->format('H:i:s') : null,
                'datedepart' => $result->getDatedepart() ? $result->getDatedepart()->format('Y-m-d H:i:s') : null,
                'datearrive' => $result->getDatearrive() ? $result->getDatearrive()->format('Y-m-d H:i:s') : null,
                'nbrescale' => $result->getNbrescale(),
                'nbrplace' => $result->getNbrplace(),
                'classe' => $result->getClasse(),
                'prix' => $result->getPrix(),
                // Add other fields as needed
            ];
        }

        return new JsonResponse($formattedResults);
    }




}