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
        // Create a new instance of the Offres entity
        $offres = new Offres();
    
        // Create the form using OffresType form class and pass the $offres entity
        $form = $this->createForm(OffresType::class, $offres);
        
        // Handle the submitted form data
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Retrieve the uploaded image file from the form
            $imageFile = $form->get('image')->getData();
        
            if ($imageFile) {
                // Upload the image file to Cloudinary using the Cloudinary service
                $result = $cloudinary->uploadApi()->upload($imageFile);
                $newFilename = $result['secure_url'];
            
                // Set the image filename to the Offres entity
                $offres->setImage($newFilename);
            }
    
            // Persist the Offres entity to the database
            $em = $this->getDoctrine()->getManager();
            $em->persist($offres);
            $em->flush();
    
            // Redirect to a specific route after successful form submission
            return $this->redirectToRoute('app_backoffice_blank');
        }
    
        // Render the template with the form view
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
                // Upload the image file to Cloudinary using the Cloudinary service
                $result = $cloudinary->uploadApi()->upload($imageFile);
                $newFilename = $result['secure_url'];
            
                // Set the image filename to the Offres entity
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
