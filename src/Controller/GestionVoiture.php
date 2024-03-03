<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function createVoiture(Request $request, ManagerRegistry $managerRegistry, SluggerInterface $slugger)
    {
        $voiture= new Voiture();
        $form= $this->createForm(VoitureType::class,$voiture);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //add the image
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('image_file_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new HttpException(Response::HTTP_BAD_REQUEST, 'This is an error message.');
                }

                $voiture->setImageFileName($newFilename);
            }

            //save voiture in the database
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
        //delete the image
        $oldFilename = $voiture->getImageFileName();
        if ($oldFilename) {
            $oldFilePath = $this->getParameter('image_file_directory') . '/' . $oldFilename;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }
        
        $em=$managerRegistry->getManager();
        $em->remove($voiture);
        $em->flush();

        return $this->redirectToRoute("app_listVoiture");
    }

    #[Route('/backoffice/voiture/update/{id}', name: 'app_updateVoiture')]
    public function updateVoiture(Request $request, $id, VoitureRepository $repository, ManagerRegistry $managerRegistry, SluggerInterface $slugger)
    {
        $voiture=$repository->find($id);
        $form=$this->createForm(VoitureType::class,$voiture);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //add the image
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                //delete the old image
                $oldFilename = $voiture->getImageFileName();
                if ($oldFilename) {
                    $oldFilePath = $this->getParameter('image_file_directory') . '/' . $oldFilename;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                
                //save the new image
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('image_file_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new HttpException(Response::HTTP_BAD_REQUEST, 'This is an error message.');
                }

                $voiture->setImageFileName($newFilename);
            }

            //save the new data to the db
            $em=$managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute("app_listVoiture");
        }
        return $this->renderForm("backoffice/GestionVoiture/updateVoiture.html.twig",["formulaireVoiture"=>$form]);
    }

}
