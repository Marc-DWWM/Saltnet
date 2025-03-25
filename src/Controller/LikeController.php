<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Like;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class LikeController extends AbstractController
{
    #[Route('/post/{id}/like', name: 'post_like', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function like(Post $post, EntityManagerInterface $em): JsonResponse
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // vérifie si l'utilisateur a déjà liké le post
        $like = $em->getRepository(Like::class)->findOneBy(['post' => $post, 'user' => $user]);

        if ($like) {
            // si post déjà liké, on enlève le like
            $em->remove($like);
        } else {
            // si pas liké on ajoute le like
            $newLike = new Like();
            $newLike->setPostLike($post);
            $newLike->setUserLike($user);
            $em->persist($newLike);
        }

        $em->flush();

        // Retourner une réponse JSON
        return $this->json([
            'status' => 'success',
            'liked' => $like ? false : true,
            'likeCount' => count($post->getLikes())
        ]);
    }
}
