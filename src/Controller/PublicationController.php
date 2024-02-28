<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Entity\Publication;
use App\Entity\Like;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ForumCommentaireRepository;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Mapping as ORM;

#[Route('/publication')]
class PublicationController extends AbstractController
{

    private $publicationRepository;
    private $params;

    public function __construct(PublicationRepository $publicationRepository, ParameterBagInterface $params)
    {
        $this->publicationRepository = $publicationRepository;
        $this->params = $params;
    }

    public function setPublication($publication)
    {
        $this->publication = $publication;
    }

    #[Route('/back', name: 'app_publication_indexback', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $sortOptions = ['id' => 'Id', 'title' => 'Title', 'shortDescription' => 'Short Description', 'content' => 'Content', 'image' => 'Image'];
        $selectedSort = $request->query->get('sort', 'id');
        $searchTerm = $request->query->get('searchTerm', '');
    
        $publications = $this->publicationRepository->findAllSortedAndSearch($selectedSort, $searchTerm);
    
        return $this->render('backoffice/publication/index.html.twig', [
            'publications' => $publications,
            'sortOptions' => $sortOptions,
            'selectedSort' => $selectedSort,
            'searchTerm' => $searchTerm,
        ]);
    }
    
    #[Route('/front', name: 'app_publication_indexfront', methods: ['GET'])]
    public function indexFront(PublicationRepository $publicationRepository): Response
    {
        return $this->render('frontoffice/publication/index.html.twig', [
            'publications' => $publicationRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_publication_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        $publication=$form->getData();
        if($request->files->get('publication')['image']){
            $image =$request->files->get('publication')['image'];
            $image_name = time().'_'.$image->getClientOriginalName();
            $image->move($this->getParameter('image_directory'),$image_name);
            $publication-> setImage($image_name);

        }
            $entityManager->persist($publication);
            $entityManager->flush();

            $this->addFlash('Success','Publication Ajouté avec Success');
            return $this->redirectToRoute('app_publication_indexback', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backoffice/publication/new.html.twig', [
            'publication' => $publication,
            'form' => $form,
        ]);
    }

          
        

    #[Route('/{id}', name: 'app_publication_showback', methods: ['GET'])]
    public function show(int $id, PublicationRepository $publicationRepository): Response
    {
        $publication = $publicationRepository->find($id);

        if (!$publication) {
            throw $this->createNotFoundException('Publication not found');
        }

        return $this->render('backoffice/publication/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    #[Route('/{id}', name: 'app_publication_showfront', methods: ['GET'])]
    public function showFront(Publication $publication): Response
    {
        return $this->render('frontoffice/publication/show.html.twig', [
            'publication' => $publication,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_publication_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id, PublicationRepository $publicationRepository, EntityManagerInterface $entityManager): Response
    {
        $publication = $publicationRepository->find($id);
    
        if (!$publication) {
            throw $this->createNotFoundException('Publication not found');
        }
    
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_publication_indexback', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('backoffice/publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}', name: 'app_publication_delete', methods: ['POST'])]
    public function delete(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        // Fetch the Publication entity using the EntityRepository
        $publication = $entityManager->getRepository(Publication::class)->find($id);

        if (!$publication) {
            throw $this->createNotFoundException('Publication not found');
        }

        if ($this->isCsrfTokenValid('delete' . $publication->getId(), $request->request->get('_token'))) {
            $entityManager->remove($publication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_publication_indexback', [], Response::HTTP_SEE_OTHER);
    }

     //show_comment
     #[Route('/{id}/show_comments', name: 'app_publication_show_comments', methods: ['GET'])]
    public function show_comments(int $id, ForumCommentaireRepository $forumCommentaireRepository): Response
    {
        $publication = $this->publicationRepository->find($id);

        if (!$publication) {
            throw $this->createNotFoundException('Publication not found');
        }

        $comments = $forumCommentaireRepository->findBy(['publication' => $publication]);

        return $this->render('backoffice/publication/show_comments.html.twig', [
            'publication' => $publication,
            'comments' => $comments,
        ]);
    }


    #[Route('/back/search', name: 'app_publication_searchback', methods: ['GET'])]
    public function search(Request $request): Response
    {
        $searchTerm = $request->query->get('searchTerm', '');
        $publications = $this->publicationRepository->findBySearchTerm($searchTerm);
    
        return $this->render('backoffice/publication/index.html.twig', [
            'publications' => $publications,
            'searchTerm' => $searchTerm,
        ]);
    }



    #[Route('/{id}/like', name: 'app_like_publication', methods: ['POST'])]
public function likePublication(Request $request, EntityManagerInterface $entityManager, int $id): Response
{
    $publication = $entityManager->getRepository(Publication::class)->find($id);

    if (!$publication) {
        throw $this->createNotFoundException('Publication not found');
    }

    $like = new Like();
    $like->setNom('like');
    $like->addPublication($publication);

    $entityManager->persist($like);
    $entityManager->flush();

    // Redirection vers la page précédente ou une autre page après avoir liké
    return $this->redirectToRoute('app_publication_indexfront');
}

#[Route('/{id}/dislike', name: 'app_dislike_publication', methods: ['POST'])]
public function dislikePublication(Request $request, EntityManagerInterface $entityManager, int $id): Response
{
    $publication = $entityManager->getRepository(Publication::class)->find($id);

    if (!$publication) {
        throw $this->createNotFoundException('Publication not found');
    }

    $like = new Like();
    $like->setNom('dislike');
    $like->addPublication($publication);

    $entityManager->persist($like);
    $entityManager->flush();

    // Redirection vers la page précédente ou une autre page après avoir disliké
    return $this->redirectToRoute('app_publication_indexfront');
}

#[Route('/{id}/reactions', name: 'app_publication_reactions', methods: ['GET'])]
public function getReactions(int $id, EntityManagerInterface $entityManager): JsonResponse
{
    $publication = $entityManager->getRepository(Publication::class)->find($id);

    if (!$publication) {
        return new JsonResponse(['error' => 'Publication not found'], Response::HTTP_NOT_FOUND);
    }

    $likes = $publication->getLikes()->count();
    $dislikes = $publication->getDislikes()->count();

    return new JsonResponse(['likes' => $likes, 'dislikes' => $dislikes]);
}


}
    
