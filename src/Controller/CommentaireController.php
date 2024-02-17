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

class CommentaireController extends AbstractController
{
    #[Route('/commentaire', name: 'app_commentaire')]
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }

    #[Route('/listCommentaire', name: 'list_commentaire')]
    public function list(ReclamationCommentaireRepository $repository)
    {
        $commentaire= $repository->findAll();

        return $this->render("frontoffice/Commentaire/listeCommentaire.html.twig",
            array('tabCommentaire'=>$commentaire));
    }


    #[Route('/addcommentaire', name: 'add_commentaire')]
    public function addCommentaire(Request $request,ManagerRegistry $managerRegistry)
    {
        $commentaire= new ReclamationCommentaire();
        $form= $this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em= $managerRegistry->getManager();
            $em->persist($commentaire);
            $em->flush();
            return new Response("Done!");
        }
        return $this->renderForm("frontoffice/Commentaire/addCommentaire.html.twig",["formulaireCommentaire"=>$form]);
    }

    #[Route('/UpdateCommentaire/{id}', name: 'app_updateCommentaire')]
    public function UpdateCommentaire(Request $request,ReclamationCommentaireRepository $repository,$id,ManagerRegistry $managerRegistry)
    {
        $commentaire=$repository->find($id);
        $form=$this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute("list_commentaire");
        }
        return $this->renderForm("frontoffice/Commentaire/updateCommentaire.html.twig",["formulaireCommentaire"=>$form]);
    }

    #[Route('/deleteCommentaire/{id}', name: 'app_deleteCommentaire')]

    public function DeleteCommentaire ($id, ReclamationCommentaireRepository $repository,ManagerRegistry $managerRegistry)
    {
        $commentaire=$repository->find($id);
        $em=$managerRegistry->getManager();
        $em->remove($commentaire);
        $em->flush();

        return $this->redirectToRoute("list_commentaire");
    }
}
