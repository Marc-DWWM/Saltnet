<?php

namespace App\Controller;


use App\Entity\Post;
use App\Entity\Like;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LikeController extends AbstractController
{
    #[Route('/post/{id}/like', name: 'post_like', methods: ['POST'])]

    public function like(EntityManagerInterface $entityManager, Post $post, LikeRepository $likeRepository): Response
    {


        $user = $this->getUser();
        //je vérifie que l'utilisateur a déja fait un like de ce post
        $existingLike = $likeRepository->findOneBy([
            'user_like' => $user,
            'post_like' => $post,
        ]);
        //si le like est déjà existant, il faut le supprimé
        if ($existingLike) {

            $entityManager->remove($existingLike);
            $entityManager->flush();

            $this->addFlash('succès', 'Vous avez déjà enlevé ce like');
        }
        //si le like n'est pas encore fait, créer le
        else {
            $like = new Like();
            $like->setUserLike($user);
            $like->setPostLike($post);

            $entityManager->persist($like);
            $entityManager->flush();
            $this->addFlash('succès', 'Vous avez liké ce post.');
        }
        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
