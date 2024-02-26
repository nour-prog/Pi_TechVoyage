<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationTypeUser;
use App\Form\ReclamationTypeAdmin;
use App\Form\ReclamationFilterType;
use App\Repository\ReclamationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Twilio\Rest\Client;



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
    public function listReclamationBack(Request $request, ReclamationRepository $repository)
    {
        $form = $this->createForm(ReclamationFilterType::class);
        $form->handleRequest($request);
    
        // Récupérer la valeur du filtre
        $estTraite = $form->get('estTraite')->getData();
    
        // Utiliser la valeur du filtre pour récupérer les réclamations
        if ($estTraite === null) {
            // Si "Toutes" est sélectionné, récupérer toutes les réclamations
            $reclamations = $repository->findAll();
        } else {
            // Sinon, filtrer par l'état de traitement
            $reclamations = $repository->findBy(['estTraite' => $estTraite]);
        }
    
        return $this->render('backoffice/Reclamation/listeReclamation.html.twig', [
            'tabReclamation' => $reclamations,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/frontoffice/listReclamation', name: 'list_reclamation_front')]
    public function listReclamationFront(ReclamationRepository $repository, Security $security)
    {
    // Récupérer l'utilisateur actuellement connecté
        $user = $security->getUser();

        if ($user) {
        // Récupérer les réclamations de l'utilisateur actuel
        $reclamations = $repository->findBy(['user' => $user]);
    }   else {
        // Gérer le cas où l'utilisateur n'est pas connecté si nécessaire
        $reclamations = [];
    }

        return $this->render("frontoffice/Reclamation/listeReclamation.html.twig",
             ['tabReclamation' => $reclamations]
    );
}

    #[Route('/addReclamation', name: 'add_reclamation')]
    public function addReclamation(Request $request)
    {
        // Créez une nouvelle instance de l'entité Reclamation
        $reclamation = new Reclamation();

        // Obtenez l'utilisateur actuel
        $user = $this->getUser();

        // Si l'utilisateur est connecté, pré-remplissez le champ de l'utilisateur dans le formulaire
        if ($user) {
            $reclamation->setUser($user);
        }
        

        // Créez le formulaire en utilisant le ReclamationTypeUser
        $form = $this->createForm(ReclamationTypeUser::class, $reclamation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Traitez le formulaire et enregistrez la réclamation
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();

            // Redirigez vers la page où vous affichez la liste des réclamations
            return $this->redirectToRoute('list_reclamation_front');
        }

        return $this->render('frontoffice/Reclamation/addReclamation.html.twig', [
            'formulaireReclamation' => $form->createView(),
        ]);
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
    public function UpdateReclamationBack(Request $request, ReclamationRepository $repository, $id, ManagerRegistry $managerRegistry)
    {
        $reclamation = $repository->find($id);
        $form = $this->createForm(ReclamationTypeAdmin::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->flush();

            // Récupérer le numéro de téléphone de l'utilisateur associé à la réclamation
            $userPhoneNumber = $reclamation->getUser()->getNumTel();

            // Envoyer le SMS
            $this->envoyerSms($userPhoneNumber, 'Votre réclamation a été traitée avec succès.');

            return $this->redirectToRoute("list_reclamation_back");
        }

        return $this->renderForm("backoffice/Reclamation/updateReclamation.html.twig", ["formulaireReclamation" => $form]);
    }

    private function envoyerSms($phoneNumber, $message)
{
    // Récupérer les paramètres Twilio depuis les paramètres Symfony
    $sid = $this->getParameter('twilio_account_sid');
    $token = $this->getParameter('twilio_auth_token');
    $twilioPhoneNumber = $this->getParameter('twilio_phone_number');

    // Supprimer les caractères non numériques du numéro de téléphone
    $cleanedPhoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    // Ajouter le préfixe international pour la Tunisie (+216)
    $cleanedPhoneNumber = '+216' . $cleanedPhoneNumber;

    // Utiliser le service SMS pour envoyer le message
    $twilio = new Client($sid, $token);
    $twilio->messages->create(
        $cleanedPhoneNumber,
        ['from' => $twilioPhoneNumber, 'body' => $message]
    );
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
