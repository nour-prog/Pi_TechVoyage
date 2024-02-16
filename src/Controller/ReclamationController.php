<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReclamationController extends AbstractController
{
    #[Route('/reclamation', name: 'app_reclamation')]
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }

    #[Route('/listReclamation', name: 'list_reclamation')]
    public function list(ReclamationRepository $repository)
    {
        $reclamation= $repository->findAll();

        return $this->render("frontoffice/Reclamation/listeReclamation.html.twig",
            array('tabReclamation'=>$reclamation));
    }

    #[Route('/addReclamation', name: 'add_reclamation')]
    public function addReclamation(Request $request,ManagerRegistry $managerRegistry)
    {
        $reclamation= new Reclamation();
        $form= $this->createForm(ReclamationType::class,$reclamation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em= $managerRegistry->getManager();
            $em->persist($reclamation);
            $em->flush();
            return new Response("Done!");
        }
        return $this->renderForm("frontoffice/Reclamation/addReclamation.html.twig",["formulaireReclamation"=>$form]);
    }

    

    #[Route('/UpdateReclamation/{id}', name: 'app_updateReclamation')]
    public function UpdateReclamation(Request $request,ReclamationRepository $repository,$id,ManagerRegistry $managerRegistry)
    {
        $reclamation=$repository->find($id);
        $form=$this->createForm(ReclamationType::class,$reclamation);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute("list_reclamation");
        }
        return $this->renderForm("frontoffice/Reclamation/updateReclamation.html.twig",["formulaireReclamation"=>$form]);

    }

    #[Route('/deleteReclamation/{id}', name: 'app_deleteReclamation')]

    public function DeleteReclamation ($id, ReclamationRepository $repository,ManagerRegistry $managerRegistry)
    {
        $reclamation=$repository->find($id);
        $em=$managerRegistry->getManager();
         $em->remove($reclamation);
         $em->flush();

        return $this->redirectToRoute("list_reclamation");
    }
}
