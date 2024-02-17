<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionDesUtilisateursController extends AbstractController
{
    #[Route('/gestion/des/utilisateurs', name: 'app_gestion_des_utilisateurs')]
    public function index(): Response
    {
        return $this->render('gestion_des_utilisateurs/index.html.twig', [
            'controller_name' => 'GestionDesUtilisateursController',
        ]);
    }

    #[Route('/listUser', name: 'list_User')]
    public function list(UserRepository $repository)
    {
        $user= $repository->findAll();

        return $this->render("backoffice/blank/listeUser.html.twig",
            array('tabUser'=>$user));
    }

    #[Route('/UpdateUser/{id}', name: 'app_UpdateUser')]
    public function UpdateUser(Request $request,UserRepository $repository,$id,ManagerRegistry $managerRegistry)
    {
        $user=$repository->find($id);
        $form=$this->createForm(RegistrationFormType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute("list_User");
        }
        return $this->renderForm("backoffice/blank/updateUser.html.twig",["formulaireUser"=>$form]);

    }

    #[Route('/deleteUser/{id}', name: 'app_deleteUser')]

    public function DeleteReclamation ($id, UserRepository $repository,ManagerRegistry $managerRegistry)
    {
        $user=$repository->find($id);
        $em=$managerRegistry->getManager();
         $em->remove($user);
         $em->flush();

        return $this->redirectToRoute("list_User");
    }
}
