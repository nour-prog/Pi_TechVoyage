<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationTypeUser;
use App\Form\ReclamationTypeAdmin;
use App\Repository\ReclamationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Twilio\Rest\Client as TwilioClient;
use App\Service\BadWordsChecker;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;



class ReclamationController extends AbstractController
{

    private $parameterBag;
    private $badWordsChecker;  

    public function __construct(ParameterBagInterface $parameterBag, BadWordsChecker $badWordsChecker)
    {
        $this->parameterBag = $parameterBag;
        $this->badWordsChecker = $badWordsChecker;
    }



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

    return $this->render('backoffice/Reclamation/listeReclamation.html.twig');
}
    
    #[Route('/frontoffice/listReclamation', name: 'list_reclamation_front')]
    public function listReclamationFront(ReclamationRepository $repository,Security $security,PaginatorInterface $paginator,Request $request) {
    $user = $security->getUser();

    $query = $repository->createQueryBuilder('r')
        ->where('r.user = :user')
        ->setParameter('user', $user)
        ->getQuery();

    $pagination = $paginator->paginate(
        $query,
        $request->query->getInt('page', 1), // Le numéro de page actuel
        10 // Nombre d'éléments par page
    );

    return $this->render("frontoffice/Reclamation/listeReclamation.html.twig", [
        'pagination' => $pagination,
    ]);
}

#[Route('/addReclamation', name: 'add_reclamation')]
public function addReclamation(Request $request): Response
{
    $reclamation = new Reclamation();
    $user = $this->getUser();

    if ($user) {
        $reclamation->setUser($user);
    }

    $form = $this->createForm(ReclamationTypeUser::class, $reclamation);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reclamation);
        $entityManager->flush();


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

            $userPhoneNumber = $reclamation->getUser()->getNumTel();

            $this->envoyerSms($userPhoneNumber, 'Votre réclamation a été traitée avec succès.');

            return $this->redirectToRoute("list_reclamation_back");
        }

        return $this->renderForm("backoffice/Reclamation/updateReclamation.html.twig", ["formulaireReclamation" => $form]);
    }

    private function envoyerSms($phoneNumber, $message)
{
    $sid = $this->getParameter('twilio_account_sid');
    $token = $this->getParameter('twilio_auth_token');
    $twilioPhoneNumber = $this->getParameter('twilio_phone_number');

    $cleanedPhoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    $cleanedPhoneNumber = '+216' . $cleanedPhoneNumber;

    $twilio = new TwilioClient($sid, $token);
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




    #[Route('/reclamation/search', name: 'app_reclamation_search')]
    public function ReclamationSearch(ReclamationRepository $repository, Request $request)
    {
        $nom = $request->query->get('nom');
        $prenom = $request->query->get('prenom');
        $estTraite = $request->query->get('estTraite');

        $queryBuilder = $repository->createQueryBuilder('r');
        $queryBuilder->leftJoin('r.user', 'u');

        //apply filters
        if ($nom !== null) {
            $queryBuilder->andWhere('u.nom LIKE :nom')
                        ->setParameter('nom', '%' . $nom . '%');
        }
        if ($prenom !== null) {
            $queryBuilder->andWhere('u.prenom LIKE :prenom')
                        ->setParameter('prenom', '%' . $prenom . '%');
        }
        if ($estTraite !== null && $estTraite !== "" ) {
            $queryBuilder->andWhere('r.estTraite = :estTraite')
                        ->setParameter('estTraite', $estTraite);
        }
        

        $reclamation = $queryBuilder->getQuery()->getResult();
        $objects = [];
        foreach ($reclamation as $rec) {
            $objects[$rec->getId()] = $rec->getObject();
        }
        return new JsonResponse($objects);
    }


}

