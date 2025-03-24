<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use App\Form\PostType;
use App\Form\CommentType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $posts = $user ? $user->getPosts() : [];

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'posts' => $posts,
            'postForm' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {

        if ($post->getUserPost() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You do not have permission to edit this post');
        }

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/repost', name: 'app_post_repost', methods: ['GET'])]
    public function repost(EntityManagerInterface $entityManager, Post $post): Response
    {

        $user = $this->getUser();

        $repost = new Post();
        $repost->setPost($post->getPost());
        $repost->setOriginalPost($post);
        $repost->setUserPost($user);

        $entityManager->persist($repost);
        $entityManager->flush();

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_post_show', methods: ['GET', 'POST'])]
    public function show(Post $post, Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            /** @var \App\Entity\User $user */
            $comment->setPostComment($post);
            $comment->setUserComment($this->getUser());
            $comment->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_post_show', ['id' => $post->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
