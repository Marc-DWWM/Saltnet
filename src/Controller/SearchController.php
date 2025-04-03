<?php

namespace App\Controller;


use App\Form\SearchType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


final class SearchController extends AbstractController
{
    #[Route('/search', name: 'search')]
    public function searchBar(Request $request, UserRepository $userRepository): Response
    {

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $users = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $query = $data['query'];
            $users = $userRepository->findBySearchQuery($query);
        }
        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
            'users' => $users,
        ]);
    }
}
