<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\Persistence\ManagerRegistry;

class GestionVoiture extends AbstractController
{
    // Backoffice: Create/read/update/delete voiture
    #[Route('/backoffice/voiture', name: 'app_listVoiture')]
    public function listVoiture(VoitureRepository $repository)
    {
        $voitures= $repository->findAll();

        return $this->render("backoffice/GestionVoiture/listVoiture.html.twig",
            array('voitureArr'=>$voitures));
    }

    #[Route('/backoffice/voiture/create', name: 'app_createVoiture')]
    public function createVoiture(Request $request, ManagerRegistry $managerRegistry)
    {
        $voiture= new Voiture();
        $form= $this->createForm(VoitureType::class,$voiture);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em= $managerRegistry->getManager();
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('app_listVoiture');
        }
        return $this->renderForm("backoffice/GestionVoiture/addVoiture.html.twig",["formulaireVoiture"=>$form]);
    }

    #[Route('/backoffice/voiture/delete/{id}', name: 'app_deleteVoiture')]
    public function deleteVoiture($id, VoitureRepository $repository, ManagerRegistry $managerRegistry)
    {
        $voiture=$repository->find($id);
        $em=$managerRegistry->getManager();
        $em->remove($voiture);
        $em->flush();

        return $this->redirectToRoute("app_listVoiture");
    }

    #[Route('/backoffice/voiture/update/{id}', name: 'app_updateVoiture')]
    public function updateVoiture(Request $request, $id, VoitureRepository $repository, ManagerRegistry $managerRegistry)
    {
        $voiture=$repository->find($id);
        $form=$this->createForm(VoitureType::class,$voiture);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute("app_listVoiture");
        }
        return $this->renderForm("backoffice/GestionVoiture/updateVoiture.html.twig",["formulaireVoiture"=>$form]);
    }

}
