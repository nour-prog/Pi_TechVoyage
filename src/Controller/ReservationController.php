<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\PdfGeneratorService;
use App\Service\MailService;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;



#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/statistique', name: 'stats')]
    public function stat()
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository(Reservation::class)->findAll();

        $Classe = [];
        $Nbrdepersonne = [];

        foreach ($reservation as $reservations) {
            $Classe = $reservations->getClasse();
            $Nbrdepersonne = $reservations->getNbrdepersonne();

            if (!isset($Classes[$Classe])) {
                $Classes[$Classe] = 0;
            }

            if (!isset($Nbrdepersonnes[$Nbrdepersonne])) {
                $Nbrdepersonnes[$Nbrdepersonne] = 0;
            }

            $Classes[$Classe]++;
            $Nbrdepersonnes[$Nbrdepersonne]++;
        }

        arsort($Classes);
        arsort($Nbrdepersonnes);

        $ClasseData = [];
        foreach ($Classes as $Classe => $count) {
            $ClasseData[] = [$Classe, $count];
        }

        $NbrdepersonneData = [];
        foreach ($Nbrdepersonnes as $Nbrdepersonne => $count) {
            $NbrdepersonneData[] = [$Nbrdepersonne, $count];
        }

        $pieChart1 = new PieChart();
        $pieChart1->getData()->setArrayToDataTable(
            array_merge([['Classe', 'nombre']], $ClasseData)
        );
        $pieChart1->getOptions()->setTitle('Statistiques sur les Classe des reservations');
        $pieChart1->getOptions()->setHeight(1000);
        $pieChart1->getOptions()->setWidth(1400);
        $pieChart1->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart1->getOptions()->getTitleTextStyle()->setColor('green');
        $pieChart1->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart1->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart1->getOptions()->getTitleTextStyle()->setFontSize(30);

        $pieChart2 = new PieChart();
        $pieChart2->getData()->setArrayToDataTable(
            array_merge([['Nbrdepersonne', 'nombre']], $NbrdepersonneData)
        );
        $pieChart2->getOptions()->setTitle('Statistiques sur les Nbrdepersonne des reservations');
        $pieChart2->getOptions()->setHeight(1000);
        $pieChart2->getOptions()->setWidth(1400);
        $pieChart2->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart2->getOptions()->getTitleTextStyle()->setColor('green');
        $pieChart2->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart2->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart2->getOptions()->getTitleTextStyle()->setFontSize(30);

        return $this->render('frontoffice/mstat/stat.html.twig', [
            'piechart1' => $pieChart1,
            'piechart2' => $pieChart2,
        ]);
    }
    #[Route('/show_in_map/{id}', name: 'app_reservation_map', methods: ['GET'])]
    public function Map( Reservation $id,EntityManagerInterface $entityManager ): Response
    {

        $reservation = $entityManager
            ->getRepository(Reservation::class)->findBy(
                ['id'=>$id]
            );
        return $this->render('frontoffice/map/api_arcgis.html.twig', [
            'reservation' => $reservation,
        ]);
    }
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('backoffice/index1.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();
            flash()->addSuccess('Votre Reservation est effectuer en succés');

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('frontoffice/reservation/new1.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

//    #[Route('/statistics', name: 'app_statistics')]
//    public function statistics(ReservationRepository $ReservationRepository): Response
//    {
//        // Récupérer tous les rendez-vous
//        $reservations = $ReservationRepository->findAll();
//
//        // Initialiser un tableau pour stocker le nombre de rendez-vous par mois
//        $reservationByMonth = [];
//
//        // Compter le nombre de rendez-vous pour chaque mois
//        foreach ($reservations as $reservation) {
//            $month = $reservation->getDatedepart()->format('M'); // Get the month abbreviation
//            $reservationsByMonth[$month] = ($reservationByMonth[$month] ?? 0) + 1;
//        }
//
//        // Passer les données à la vue
//        return $this->render('reservation/statistics.html.twig', [
//            'reservationByMonth' => $reservationByMonth,
//        ]);
//    }

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('frontoffice/reservation/show1.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('frontoffice/reservation/edit1.html.twig', [
            'reservation' => $reservation,
            'form' => $form,

        ]);
    }



    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
            flash()->addSuccess('Votre Reservation est supprimer avec succés');
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/pdf/reservation', name: 'generator_service')]
    public function pdfEvenement(): Response
    {
        $reservation= $this->getDoctrine()
            ->getRepository(Reservation::class)
            ->findAll();



        $html =$this->renderView('frontoffice/mpdf/index.html.twig', ['reservations' => $reservation]);
        $pdfGeneratorService=new PdfGeneratorService();
        $pdf = $pdfGeneratorService->generatePdf($html);

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);

    }


}
