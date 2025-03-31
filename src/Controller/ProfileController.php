<?php

namespace App\Controller;

use App\Entity\Repost;
use App\Form\PictureProfilType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/profil', name: 'profile_')]

final class ProfileController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, PostRepository $postRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $posts = $user->getPosts();
        $postComments = $user->getComments();
        $reposts = $user->getReposts();
        $page = $request->query->getInt('page', 1);
        $limit = 10;
        $posts = $postRepository->paginatePosts($page, $limit);
        $maxPage = ceil($posts->count() / $limit);



        return $this->render('profile/index.html.twig', [
            'posts' => $posts,
            'postComments' => $postComments,
            'reposts' => $reposts,
            'maxPage' => $maxPage,
            'page' => $page,
        ]);
    }





    #[Route('/modifier', name: 'modifier')]
    public function uploadPicture(
        Request $request,
        SluggerInterface $slugger,
        #[Autowire('%kernel.project_dir%/public/uploads')] string $picturesDirectory,
        EntityManagerInterface $entityManager,

    ): Response {
        $user = $this->getUser();
        $form = $this->createForm(PictureProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $pictureFile */
            $pictureFile = $form->get('picture')->getData();
            if ($pictureFile) {
                /** @var \App\Entity\User $user */
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);

                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();

                try {
                    $pictureFile->move($picturesDirectory, $newFilename);
                } catch (FileException $e) {
                    echo "Image non valide " . $e->getMessage();
                }
                $user->setPhoto($newFilename);
            }
            $entityManager->persist($user);
            $entityManager->flush();


            return $this->redirectToRoute('profile_index');
        }
        return $this->render('profile/modifier.html.twig', [
            'pictureProfil' => $form->createView(),
            'user' => $user,
        ]);
    }
}
