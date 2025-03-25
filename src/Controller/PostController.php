<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\PostType;
use App\Form\CommentType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/post')]
final class PostController extends AbstractController
{
    #[Route(name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findBy(['originalPost' => null]);

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PostRepository $postRepository): Response
    {
        $user = $this->getUser();
        $post = new Post($user);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_show', methods: ['GET', 'POST'])]
    public function show(Post $post, Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
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

    #[Route('/{id}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($post->getUserPost() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'êtes pas l'auteur de ce post");
        }

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager, PostRepository $postRepository): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Token CSRF invalide');
        }

        $user = $this->getUser();

        // vérifie que c'est bien l'utilisateur du post qui veut le supprimé
        if ($post->getUserPost() !== $user) {
            throw $this->createAccessDeniedException("Vous n'êtes pas l'utilisateur de ce post.");
        }
        // je récupere tous les repost qui sont associé au post originel
        $reposts = $postRepository->findBy(['originalPost' => $post]);
        // je supprime tou les repost trouvé
        foreach ($reposts as $repost) {
            $entityManager->remove($repost);
        }
        //je supprime également le post originel
        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}/repost', name: 'app_post_repost', methods: ['GET'])]
    public function repost(EntityManagerInterface $entityManager, Post $post, PostRepository $postRepository): Response
    {

        $user = $this->getUser();
        // je vérifie que l'utilisateur a déja fait un repost de ce post
        $existingRepost = $postRepository->findOneBy([
            'originalPost' => $post,
        ]);
        // si le repost est déjà existant, il faut le supprimé
        if ($existingRepost) {

            $entityManager->remove($existingRepost);
            $entityManager->flush();

            $this->addFlash('succès', 'Vous avez déjà enlevé ce post');
        }
        // si le repost n'est pas encore fait, créer le
        else {
            $repost = new Post();
            $repost->setPost($post->getPost());
            $repost->setOriginalPost($post);
            $repost->setUserPost($user);

            $entityManager->persist($repost);
            $entityManager->flush();
            $this->addFlash('succès', 'Vous avez reposté ce post.');
        }
        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
