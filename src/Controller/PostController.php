<?php

namespace App\Controller;

use App\Entity\Repost;
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
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


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

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

    // création de nouveau post
    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PostRepository $postRepository): Response
    {
        $user = $this->getUser();
        $post = new Post();
        $post->setUserPost($user);

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

    // fonctionnalité pour voir les posts et les commentaires avec formulaire de création de commentaire
    #[Route('/{id}', name: 'app_post_show', methods: ['GET', 'POST'])]
    public function show(Post $post, Request $request, EntityManagerInterface $entityManager, PostRepository $postRepository): Response
    {
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        $page = $request->query->getInt('page', 1);
        $limit = 10;
        $posts = $postRepository->paginatePosts($page, $limit);
        $maxPage = ceil($posts->count() / $limit);


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
            'maxPage' => $maxPage,
            'page' => $page,
        ]);
    }

    // fonctionnalités pour modifier un post
    #[Route('/{id}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {

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
    // fonctionnalités de suppresion de post
    #[Route('/{id}/delete', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager, PostRepository $postRepository): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $post->getId(), $request->request->getString('_token'))) {
            throw new BadRequestHttpException('This token is invalid');
        }


        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

    // ici on fait les reposts ou on enleve le repost si déja fait sur le post
    #[Route('/{id}/repost', name: 'app_post_repost', methods: ['GET'])]
    public function repost(EntityManagerInterface $entityManager, Post $post): Response
    {
        $user = $this->getUser();

        //je vérifié si l'utilisateur a bien repost ce post
        $Repost = $entityManager->getRepository(Repost::class)->findOneBy([
            'originalPost' => $post,
            'userRepost' => $user,
        ]);

        //si déja repost dérepost le post
        if ($Repost) {
            $entityManager->remove($Repost);
            $entityManager->flush();

            $this->addFlash('success', 'Vous avez déjà supprimé ce repost');
        }
        // si repost inexistant le créer
        else {

            $repost = new Repost();
            $repost->setOriginalPost($post);
            $repost->setUserRepost($user);
            $entityManager->persist($repost);
            $entityManager->flush();

            $this->addFlash('success', 'Vous avez reposté ce post');
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
