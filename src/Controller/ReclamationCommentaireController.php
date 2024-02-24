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

    #[Route('/backoffice/listCommentaire', name: 'list_commentaire_back')]
    public function listCommenatireBack(ReclamationCommentaireRepository $repository)
    {
        $commentaire= $repository->findAll();

        return $this->render("backoffice/ReclamationCommentaire/listeCommentaire.html.twig",
            array('tabCommentaire'=>$commentaire));
    }

    #[Route('/frontoffice/listCommentaire', name: 'list_commentaire_front')]
public function listCommentaireFront(ReclamationRepository $reclamationRepository, Security $security)
{
    // Récupérer l'utilisateur actuellement connecté
    $user = $security->getUser();

    if ($user) {
        // Récupérer les réclamations de l'utilisateur actuel
        $reclamations = $reclamationRepository->findBy(['user' => $user]);

        // Initialiser un tableau pour stocker les commentaires de l'utilisateur
        $commentaires = [];

        // Parcourir les réclamations de l'utilisateur
        foreach ($reclamations as $reclamation) {
            // Ajouter les commentaires de chaque réclamation
            $commentaires = array_merge($commentaires, $reclamation->getReclamationCommentaires()->toArray());
        }
    } else {
        // Gérer le cas où l'utilisateur n'est pas connecté si nécessaire
        $commentaires = [];
    }

    return $this->render("frontoffice/ReclamationCommentaire/listeCommentaire.html.twig", [
        'tabCommentaire' => $commentaires,
    ]);
}



    #[Route('/addCommentaireFront', name: 'add_commentaire_front')]
    public function addCommentaireFront(Request $request,ManagerRegistry $managerRegistry)
    {
        $commentaire= new ReclamationCommentaire();
        $form= $this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em= $managerRegistry->getManager();
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute("list_commentaire_front");
        }
        return $this->renderForm("frontoffice/ReclamationCommentaire/addCommentaire.html.twig",["formulaireCommentaire"=>$form]);
    }


    #[Route('/addCommentaireBack', name: 'add_commentaire_back')]
    public function addCommentaireBack(Request $request,ManagerRegistry $managerRegistry)
    {
        $commentaire= new ReclamationCommentaire();
        $form= $this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em= $managerRegistry->getManager();
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute("list_commentaire_back");
        }
        return $this->renderForm("backoffice/ReclamationCommentaire/addCommentaire.html.twig",["formulaireCommentaire"=>$form]);
    }

    #[Route('/UpdateCommentaireFront/{id}', name: 'app_updateCommentaire_front')]
    public function UpdateCommentaire(Request $request,ReclamationCommentaireRepository $repository,$id,ManagerRegistry $managerRegistry)
    {
        $commentaire=$repository->find($id);
        $form=$this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute("list_commentaire_front");
        }
        return $this->renderForm("frontoffice/ReclamationCommentaire/updateCommentaire.html.twig",["formulaireCommentaire"=>$form]);
    }

    #[Route('/UpdateCommentaireBack/{id}', name: 'app_updateCommentaire_back')]
    public function UpdateCommentaireBack(Request $request,ReclamationCommentaireRepository $repository,$id,ManagerRegistry $managerRegistry)
    {
        $commentaire=$repository->find($id);
        $form=$this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute("list_commentaire_back");
        }
        return $this->renderForm("backoffice/ReclamationCommentaire/updateCommentaire.html.twig",["formulaireCommentaire"=>$form]);
    }

    #[Route('/deleteCommentaireFront/{id}', name: 'app_deleteCommentaire_front')]

    public function DeleteCommentaireFront ($id, ReclamationCommentaireRepository $repository,ManagerRegistry $managerRegistry)
    {
        $commentaire=$repository->find($id);
        $em=$managerRegistry->getManager();
        $em->remove($commentaire);
        $em->flush();

        return $this->redirectToRoute("list_commentaire_front");
    }

    #[Route('/deleteCommentaireBack/{id}', name: 'app_deleteCommentaire_back')]

    public function DeleteCommentaireBack ($id, ReclamationCommentaireRepository $repository,ManagerRegistry $managerRegistry)
    {
        $commentaire=$repository->find($id);
        $em=$managerRegistry->getManager();
        $em->remove($commentaire);
        $em->flush();

        return $this->redirectToRoute("list_commentaire_back");
    }
}
