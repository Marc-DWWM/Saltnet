<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Post;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


class LikeController extends AbstractController
{
    #[Route('/post/{id}/like', name: 'post_like', methods: ['POST'])]

    public function like(Post $post, UserInterface $user, LikeRepository $likeRepository, EntityManagerInterface $entityManager): Response
    {


        //je vérifie que l'utilisateur a déja fait un like de ce post
        $existLike = $likeRepository->findOneBy([
            'user_like' => $user,
            'post_like' => $post,
        ]);
        //si le like est déjà existant, il faut le supprimé
        if ($existLike) {

            $entityManager->remove($existLike);
            $entityManager->flush();

            $this->addFlash('succès', 'Vous avez déjà supprimé ce like');
        }
        //si le like n'est pas encore fait, créer le
        else {
            $like = new Like();
            $like->setUserLike($user);
            $like->setPostLike($post);
            $like->setLikeAt(new \DateTimeImmutable());

            $entityManager->persist($like);
            $entityManager->flush();
            $this->addFlash('succès', 'Vous avez liké ce post.');
        }
        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
