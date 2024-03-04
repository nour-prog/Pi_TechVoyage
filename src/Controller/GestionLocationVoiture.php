<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\LocationVoiture;
use App\Form\AddLocationVoitureType;
use App\Form\UpdateLocationVoitureType;
use App\Form\ReserveLocationVoitureType;
use App\Repository\LocationVoitureRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GestionLocationVoiture extends AbstractController
{
    // Backoffice: Create/read/update/delete location voiture
    #[Route('/backoffice/locationVoiture', name: 'app_listLocationVoiture')]
    public function listVoiture(LocationVoitureRepository $repository)
    {
        $locationVoitures= $repository->findAll();

        return $this->render("backoffice/GestionLocationVoiture/list.html.twig",
            array('locationVoitureArr'=>$locationVoitures));
    }

    #[Route('/backoffice/locationVoiture/create', name: 'app_createLocationVoiture')]
    public function createVoiture(Request $request, ManagerRegistry $managerRegistry)
    {
        $locationVoiture= new LocationVoiture();
        $form= $this->createForm(AddLocationVoitureType::class,$locationVoiture);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em= $managerRegistry->getManager();
            $em->persist($locationVoiture);
            $em->flush();
            return $this->redirectToRoute('app_listLocationVoiture');
        }
        return $this->renderForm("backoffice/GestionLocationVoiture/add.html.twig",["formulaireLocationVoiture"=>$form]);
    }

    #[Route('/backoffice/locationVoiture/delete/{id}', name: 'app_deleteLocationVoiture')]
    public function deleteVoiture($id, LocationVoitureRepository $repository, ManagerRegistry $managerRegistry)
    {
        $locationVoiture=$repository->find($id);
        $em=$managerRegistry->getManager();
        $em->remove($locationVoiture);
        $em->flush();

        return $this->redirectToRoute("app_listLocationVoiture");
    }

    #[Route('/backoffice/locationVoiture/update/{id}', name: 'app_updateLocationVoiture')]
    public function updateVoiture(Request $request, $id, LocationVoitureRepository $repository, ManagerRegistry $managerRegistry)
    {
        $locationVoiture=$repository->find($id);
        $form=$this->createForm(UpdateLocationVoitureType::class,$locationVoiture);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute("app_listLocationVoiture");
        }
        return $this->renderForm("backoffice/GestionLocationVoiture/update.html.twig",["formulaireLocationVoiture"=>$form]);
    }

    // Frontoffice: consult/reserve location voiture
    #[Route('/locationVoiture', name: 'app_listLocationVoiture_user')]
    public function listVoiture_user(LocationVoitureRepository $repository)
    {
        // $locationVoitures= $repository->findAll();
        $locationVoitures = $repository->findBy(['status' => 'disponible']);
        
        return $this->render("frontoffice/GestionLocationVoiture/list.html.twig",
            array('locationVoitureArr'=>$locationVoitures));
    }
    

    #[Route('/locationVoiture/myReserved', name: 'app_listReserved_user')]
    public function listReserved_user(LocationVoitureRepository $repository)
    {
        // $locationVoitures= $repository->findAll();
        $locationVoitures = $repository->findBy(['status' => 'réservé']);
        
        return $this->render("frontoffice/GestionLocationVoiture/reservedList.html.twig",
            array('locationVoitureArr'=>$locationVoitures));
    }

    #[Route('/locationVoiture/myReserved/recu/{id}', name: 'app_reservedRecu_user')]
    public function reservedRecu_user(LocationVoitureRepository $repository, $id)
    {
        $locationVoiture = $repository->find($id);
        if ($locationVoiture) {
            if ($locationVoiture->getStatus() === "réservé") {
                $html = $this->renderView('frontoffice/GestionLocationVoiture/recuPdf.html.twig',[
                    "locationVoiture" => $locationVoiture
                ]);
                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
        
                // $dompdf->stream('récu.pdf');
        
                return new Response($dompdf->output(), 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="your_pdf_filename.pdf"',
                ]);
            } else {
                throw new NotFoundHttpException("Le Recu demandé n'a pas pu être trouvé.");
            }
        } else {
            throw new NotFoundHttpException("La Voiture demandé n'a pas pu être trouvé.");
        }
    }
    

    #[Route('/locationVoiture/reserve/{id}', name: 'app_reserveVoiture_user')]
    public function reserveVoiture_user(Request $request, $id, LocationVoitureRepository $repository, ManagerRegistry $managerRegistry)
    {
        $locationVoiture=$repository->find($id);
        $voiture=$locationVoiture->getVoiture();
        $form=$this->createForm(ReserveLocationVoitureType::class,$locationVoiture);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //update the status to réservé
            $locationVoiture->setStatus("réservé");
            //update the db
            $em=$managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute("app_listLocationVoiture_user");
        }
        return $this->renderForm("frontoffice/GestionLocationVoiture/reserveVoiture.html.twig",["formulaireLocationVoiture"=>$form, "locationVoiture"=>$locationVoiture ,"voiture"=>$voiture]);
    }

    #[Route('/locationVoiture/search', name: 'app_searchLocationVoiture_user')]
    public function searchVoiture_user(LocationVoitureRepository $repository, Request $request)
    {
        $type = $request->query->get('type');
        $marque = $request->query->get('marque');
        $maxPrix = $request->query->get('maxPrix');
        $minPrix = $request->query->get('minPrix');

        $queryBuilder = $repository->createQueryBuilder('lv');
        $queryBuilder->leftJoin('lv.voiture', 'v');

        //apply filters
        if ($type !== null) {
            $queryBuilder->andWhere('lv.type LIKE :type')
                        ->setParameter('type', '%' . $type . '%');
        }
        if ($marque !== null) {
            $queryBuilder->andWhere('v.marque LIKE :marque')
                        ->setParameter('marque', '%' . $marque . '%');
        }
        if ($maxPrix !== null) {
            $queryBuilder->andWhere('lv.prix <= :maxPrix')
                        ->setParameter('maxPrix', $maxPrix);
        }
        if ($minPrix !== null) {
            $queryBuilder->andWhere('lv.prix >= :minPrix')
                        ->setParameter('minPrix', $minPrix);
        }
        $queryBuilder->andWhere('lv.status = :status')
                    ->setParameter('status', "disponible");
        $locations = $queryBuilder->getQuery()->getResult();
        $objects = [];
        foreach ($locations as $locationVoiture) {
            $objects[$locationVoiture->getId()] = $locationVoiture->getObject();
        }
        return new JsonResponse($objects);
    }
}