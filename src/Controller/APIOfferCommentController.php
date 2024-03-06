<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\OffreCommentaire;
use  App\Repository\OffreCommentaireRepository;
class APIOfferCommentController extends AbstractController
{
    #[Route('api/offer/addreplycomment', methods:"POST")]
    public function index(Request $request,OffreCommentaireRepository $offrecommentaireRepository): JsonResponse
    {
 
          
        $commentId = $request->request->get("commentId");
        $commentValue = $request->request->get("commentValue");
        $parentComment = $offrecommentaireRepository->find($commentId);

        if (!$parentComment) {
            return new JsonResponse(['error' => 'Parent comment not found'], 404);
        }
        $comment = new OffreCommentaire();
        $comment->setAvis($commentValue);
        $comment->setParent($parentComment); // Associate the reply with the parent comment
        $comment->setOffres($parentComment->getOffres());
        // Optionally, set other properties of the comment entity, such as user, timestamp, etc.

        // Persist the new comment entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();
       
        return new JsonResponse(['message' => 'This is your API response',
        "comment"=>$comment
    
    ]);

    }

    #[Route('api/offer/toggleComment', methods:"POST")]
    public function toggleComment(Request $request,OffreCommentaireRepository $offrecommentaireRepository): JsonResponse
    {
 
          
        $commentId = $request->request->get("commentId");

        $parent= $offrecommentaireRepository->find($commentId);

        if (!$parent) {
            return new JsonResponse(['error' => 'Parent comment not found'], 404);
        }
        $parent->setActive(!$parent->isActive());
        // Optionally, set other properties of the comment entity, such as user, timestamp, etc.

        // Persist the new comment entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($parent);
        $entityManager->flush();
       
        return new JsonResponse(['message' => 'This is your API response'
    
    ]);

    }
}
