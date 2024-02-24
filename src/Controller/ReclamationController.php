<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationTypeUser;
use App\Form\ReclamationTypeAdmin;
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

    #[Route('/backoffice/listReclamation', name: 'list_reclamation_back')]
    public function listReclamationBack(ReclamationRepository $repository)
    {
        $reclamation= $repository->findAll();

        return $this->render("backoffice/Reclamation/listeReclamation.html.twig",
            array('tabReclamation'=>$reclamation));
    }

    #[Route('/frontoffice/listReclamation', name: 'list_reclamation_front')]
    public function listReclamationFront(ReclamationRepository $repository)
    {
        $reclamation= $repository->findAll();

        return $this->render("frontoffice/Reclamation/listeReclamation.html.twig",
            array('tabReclamation'=>$reclamation));
    }

    #[Route('/addReclamation', name: 'add_reclamation')]
    public function addReclamation(Request $request,ManagerRegistry $managerRegistry)
    {
        $reclamation= new Reclamation();
        $form= $this->createForm(ReclamationTypeUser::class,$reclamation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em= $managerRegistry->getManager();
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute("list_reclamation_front");
        }
        return $this->renderForm("frontoffice/Reclamation/addReclamation.html.twig",["formulaireReclamation"=>$form]);
    }

    

    #[Route('/UpdateReclamationFront/{id}', name: 'app_updateReclamation_front')]
    public function UpdateReclamationFront(Request $request,ReclamationRepository $repository,$id,ManagerRegistry $managerRegistry)
    {
        $reclamation=$repository->find($id);
        $form=$this->createForm(ReclamationTypeUser::class,$reclamation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute("list_reclamation_front");
        }
        return $this->renderForm("frontoffice/Reclamation/updateReclamation.html.twig",["formulaireReclamation"=>$form]);

    }

    #[Route('/backoffice/UpdateReclamationBack/{id}', name: 'app_updateReclamation_back')]
    public function UpdateReclamationBack(Request $request,ReclamationRepository $repository,$id,ManagerRegistry $managerRegistry)
    {
        $reclamation=$repository->find($id);
        $form=$this->createForm(ReclamationTypeAdmin::class,$reclamation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute("list_reclamation_back");
        }
        return $this->renderForm("backoffice/Reclamation/updateReclamation.html.twig",["formulaireReclamation"=>$form]);
    }

    #[Route('/backoffice/deleteReclamationBack/{id}', name: 'app_deleteReclamation_back')]

    public function DeleteReclamationBack ($id, ReclamationRepository $repository,ManagerRegistry $managerRegistry)
    {
        $reclamation=$repository->find($id);
        $em=$managerRegistry->getManager();
         $em->remove($reclamation);
         $em->flush();

        return $this->redirectToRoute("list_reclamation_back");
    }

    #[Route('/deleteReclamationFront/{id}', name: 'app_deleteReclamation_front')]

    public function DeleteReclamationFront ($id, ReclamationRepository $repository,ManagerRegistry $managerRegistry)
    {
        $reclamation=$repository->find($id);
        $em=$managerRegistry->getManager();
         $em->remove($reclamation);
         $em->flush();

        return $this->redirectToRoute("list_reclamation_front");
    }
}
