<?php

namespace App\Controller;
use App\Form\OffreCommentaireType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\OffreCommentaire;
use  App\Repository\OffreCommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OffreCommentaireController extends AbstractController
{
    #[Route('/offre/commentaire', name: 'app_offre_commentaire')]
    public function index(Request $request): Response
    {
        $offrecommentaire = new OffreCommentaire();
        $form = $this->createForm(OffreCommentaireType::class,$offrecommentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($offrecommentaire);
            $em->flush();
            return $this->redirectToRoute('app_affichecommentaire');
    
        }
        return $this->render('frontoffice/offre_commentaire/index.html.twig', [
            'form' => $form->createView(),
        ]);

    }
        #[Route('offrecommentaires/{id}/delete', name: 'app_delete')]
        public function delete($id, OffreCommentaireRepository $offrecommentaireRepository): RedirectResponse
        {
            $offrecommentaire = $offrecommentaireRepository->find($id);
            
            $em = $this->getDoctrine()->getManager();
            $em->remove($offrecommentaire);
            $em->flush();
            
            return $this->redirectToRoute('app_backoffice_blank');
        }
    
    



}
