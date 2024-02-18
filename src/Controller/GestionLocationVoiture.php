<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\LocationVoiture;
use App\Form\AddLocationVoitureType;
use App\Form\UpdateLocationVoitureType;
use App\Repository\LocationVoitureRepository;
use Doctrine\Persistence\ManagerRegistry;

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
        if($form->isSubmitted()){
            $em=$managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute("app_listLocationVoiture");
        }
        return $this->renderForm("backoffice/GestionLocationVoiture/update.html.twig",["formulaireLocationVoiture"=>$form]);
    }

    // Frontoffice: reserve location voiture

}