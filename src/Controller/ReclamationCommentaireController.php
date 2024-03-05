<?php

namespace App\Controller;

use App\Entity\ReclamationCommentaire;
use App\Form\CommentaireType;
use App\Repository\ReclamationCommentaireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReclamationRepository;
use Symfony\Component\Security\Core\Security;




class ReclamationCommentaireController extends AbstractController
{
    #[Route('/commentaire', name: 'app_commentaire')]
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }

    #[Route('/backoffice/ShowReclamation/{id}', name: 'Show_Reclamation_back')]
    public function ShowReclamationBack(ReclamationRepository $reclamationRepository , $id , Security $security)
   {        
        $user = $security->getUser();
        $userID = $user ->getId();
        $reclamations = $reclamationRepository->find($id);

        $commentaires = $reclamations->getReclamationCommentaires()->toArray();

        return $this->render("backoffice/ReclamationCommentaire/ShowReclamation.html.twig", [
        'tabCommentaire' => $commentaires, 'reclamation' => $reclamations , 'UserId' => $userID]);
    }

    #[Route('/frontoffice/ShowReclamation/{id}', name: 'Show_Reclamation_front')]
    public function ShowReclamationFront(ReclamationRepository $reclamationRepository , $id , Security $security)
   {        
        $user = $security->getUser();
        $userID = $user ->getId();
        $reclamations = $reclamationRepository->find($id);

        $commentaires = $reclamations->getReclamationCommentaires()->toArray();

        return $this->render("frontoffice/ReclamationCommentaire/ShowReclamation.html.twig", [
        'tabCommentaire' => $commentaires, 'reclamation' => $reclamations , 'UserId' => $userID]);
    }
 


    #[Route('/addCommentaireFront/{id}', name: 'add_commentaire_front')]
    public function addCommentaireFront(Request $request,Security $security,ManagerRegistry $managerRegistry,$id, ReclamationRepository $reclamationRepository)
    {
        $user = $security->getUser();

        $commentaire= new ReclamationCommentaire();
        $form= $this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $reclamations = $reclamationRepository->find($id);
            $commentaire -> setReclamation($reclamations);
            $commentaire -> setUser($user);

            $em= $managerRegistry->getManager();
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute("Show_Reclamation_front", ['id' => $id ] );
        }
        return $this->renderForm("frontoffice/ReclamationCommentaire/addCommentaire.html.twig",["formulaireCommentaire"=>$form]);
    }

    #[Route('/addCommentaireBack/{id}', name: 'add_commentaire_back')]
    public function addCommentaireBack2(Request $request,Security $security,ManagerRegistry $managerRegistry,$id, ReclamationRepository $reclamationRepository)
    {
        $user = $security->getUser();

        $commentaire= new ReclamationCommentaire();
        $form= $this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $reclamations = $reclamationRepository->find($id);
            $commentaire -> setReclamation($reclamations);
            $commentaire -> setUser($user);

            $em= $managerRegistry->getManager();
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute("Show_Reclamation_back", ['id' => $id ] );
        }
        return $this->renderForm("backoffice/ReclamationCommentaire/addCommentaire.html.twig",["formulaireCommentaire"=>$form]);
    }

    #[Route('/UpdateCommentaireFront/{id}', name: 'app_updateCommentaire_front')]
    public function UpdateCommentaire(Request $request,ReclamationCommentaireRepository $repository,$id,ManagerRegistry $managerRegistry)
    {
        $commentaire=$repository->find($id);
        $reclamationId= $commentaire->getReclamation()->getId();
        $form=$this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute("Show_Reclamation_front", ['id' => $reclamationId ]);
        }
        return $this->renderForm("frontoffice/ReclamationCommentaire/updateCommentaire.html.twig",["formulaireCommentaire"=>$form]);
    }

    #[Route('/UpdateCommentaireBack/{id}', name: 'app_updateCommentaire_back')]
    public function UpdateCommentaireBack(Request $request,ReclamationCommentaireRepository $repository,$id,ManagerRegistry $managerRegistry)
    {
        $commentaire=$repository->find($id);
        $reclamationId= $commentaire->getReclamation()->getId();
        $form=$this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute("Show_Reclamation_back", ['id' => $reclamationId ]);
        }
        return $this->renderForm("backoffice/ReclamationCommentaire/updateCommentaire.html.twig",["formulaireCommentaire"=>$form]);
    }

    #[Route('/deleteCommentaireFront/{id}', name: 'app_deleteCommentaire_front')]

    public function DeleteCommentaireFront ($id, ReclamationCommentaireRepository $repository,ManagerRegistry $managerRegistry)
    {
        $commentaire=$repository->find($id);
        $reclamationId= $commentaire->getReclamation()->getId();
        $em=$managerRegistry->getManager();
        $em->remove($commentaire);
        $em->flush();

        return $this->redirectToRoute("Show_Reclamation_front", ['id' => $reclamationId ]);
    }

    #[Route('/deleteCommentaireBack/{id}', name: 'app_deleteCommentaire_back')]

    public function DeleteCommentaireBack ($id, ReclamationCommentaireRepository $repository,ManagerRegistry $managerRegistry)
    {
        $commentaire=$repository->find($id);
        $reclamationId= $commentaire->getReclamation()->getId();
        $em=$managerRegistry->getManager();
        $em->remove($commentaire);
        $em->flush();

        return $this->redirectToRoute("Show_Reclamation_back", ['id' => $reclamationId ]);
    }
}
