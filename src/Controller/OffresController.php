<?php

namespace App\Controller;
use App\Form\OffresType;
use App\Repository\OffresRepository;
use App\Entity\Offres;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Cloudinary\Cloudinary;
class OffresController extends AbstractController
{
    #[Route('offres/ajouter', name: 'offres_ajout')]
    public function index(Request $request, Cloudinary $cloudinary): Response
    {
        
        $offres = new Offres();
    
        
        $form = $this->createForm(OffresType::class, $offres);
        
        
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            
            $imageFile = $form->get('image')->getData();
        
            if ($imageFile) {
                
                $result = $cloudinary->uploadApi()->upload($imageFile);
                $newFilename = $result['secure_url'];
            
                
                $offres->setImage($newFilename);
            }
    
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($offres);
            $em->flush();
    
            
            return $this->redirectToRoute('app_backoffice_blank');
        }
    
        
        return $this->render('backoffice/offres/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('offres/{id}/editer', name: 'offres_edit', methods: ['GET', 'POST'])]
    public function edit( $id,Request $request,OffresRepository $OffresRepository, Cloudinary $cloudinary): Response
    {
        $offres=$OffresRepository->find($id);
        $form = $this->createForm(OffresType::class,$offres);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $imageFile = $form->get('image')->getData();
        
            if ($imageFile) {
                
                $result = $cloudinary->uploadApi()->upload($imageFile);
                $newFilename = $result['secure_url'];
            
                
                $offres->setImage($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute(route:'app_backoffice_blank');
        }
        return $this->render('backoffice/offres/edit.html.twig', [
            "form" => $form->createView() 
            
        ]);
    }
    #[Route('offres/{id}/delete', name: 'offres_delete')]
    public function delete($id, OffresRepository $offresRepository): RedirectResponse
    {
        $offres = $offresRepository->find($id);
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($offres);
        $em->flush();
        
        return $this->redirectToRoute('app_backoffice_blank');
    }


    #[Route('/{id}/show', name: 'offres_show')]
    public function show($id,OffresRepository $offresRepository): Response{
        $offres = $offresRepository->findBy(['id'=>$id]);
        return $this->render('frontoffice/homepage/show.html.twig',[
            "table"=>$offres,
        ]);

    }
    
}










