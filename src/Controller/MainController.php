<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PostRepository $postRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        $page = $request->query->getInt('page', 1);
        $limit = 10;
        $posts = $postRepository->paginatePosts($page, $limit);
        $maxPage = ceil($posts->count() / $limit);

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUserPost($this->getUser());
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('main/index.html.twig', [
            'posts' => $posts,
            'postForm' => $form->createView(),
            'maxPage' => $maxPage,
            'page' => $page,
        ]);
    }
}
