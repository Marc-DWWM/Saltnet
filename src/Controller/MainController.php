<?php
namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
//     // #[Route('/', name: 'home')]
//     // public function index(Request $request, EntityManagerInterface $entityManager): Response
//     {
//         // /** @var \App\Entity\User $user */
//         // $user = $this->getUser();
//         // $posts = $user ? $user->getPosts() : [];

//         // $post = new Post();
//         // $form = $this->createForm(PostType::class, $post);
//         // $form->handleRequest($request);

//         // if ($form->isSubmitted() && $form->isValid()) {
//         //     $entityManager->persist($post);
//         //     $entityManager->flush();

//         //     return $this->redirectToRoute('app_home');
//         // }

//         // return $this->render('main/index.html.twig', [
//         //     'controller_name' => 'MainController',
//         //     'posts' => $posts,
//         //     'postForm' => $form->createView(),
//         // ]);
//     }
}
