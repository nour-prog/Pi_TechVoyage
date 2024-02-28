<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class GestionDesUtilisateursController extends AbstractController
{
    #[Route('/gestion/des/utilisateurs', name: 'app_gestion_des_utilisateurs')]
    public function index(): Response
    {
        return $this->render('gestion_des_utilisateurs/index.html.twig', [
            'controller_name' => 'GestionDesUtilisateursController',
        ]);
    }

    #[Route('/backoffice/listUser', name: 'list_User')]
    public function list(UserRepository $repository)
    {
        $user= $repository->findAll();

        return $this->render("backoffice/blank/listeUser.html.twig",
            array('tabUser'=>$user));
    }



    #[Route('/listeprofile', name: 'list_profile_front')]
    public function listuserFront(UserRepository $repository, Security $security)
    {
    // Récupérer l'utilisateur actuellement connecté
        $user = $security->getUser();

        if ($user) {
        // Récupérer les données de l'utilisateur actuel
        $user = $repository->findBy(['id' => $user]);
    }   else {
        // Gérer le cas où l'utilisateur n'est pas connecté si nécessaire
        $user = [];
    }

        return $this->render("frontoffice/Profile/profile.html.twig",
             ['tabuser' => $user]
    );
}
    



    #[Route('/backoffice/UpdateUser/{id}', name: 'app_UpdateUser')]
    public function UpdateUser(Request $request,UserRepository $repository,$id,ManagerRegistry $managerRegistry)
    {
        $user=$repository->find($id);
        $form=$this->createForm(UserFormType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute("list_User");
        }
        return $this->renderForm("backoffice/blank/updateUser.html.twig",["formulaireUser"=>$form]);

    }

    #[Route('/backoffice/deleteUser/{id}', name: 'app_deleteUser')]

    public function DeleteReclamation ($id, UserRepository $repository,ManagerRegistry $managerRegistry)
    {
        $user=$repository->find($id);
        $em=$managerRegistry->getManager();
         $em->remove($user);
         $em->flush();

        return $this->redirectToRoute("list_User");
    }
}
