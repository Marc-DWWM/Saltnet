<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    private EntityManagerInterface $entityManager;


    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
    }

    public function index(): Response
    {

        $users = $this->entityManager->getRepository(User::class)->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'users' => $users,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Saltnet');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
    }

    #[Route('/admin/user/delete/{id}', name: 'admin_user_delete', methods: ['POST'])]
    public function deleteUser(Request $request, User $user, EntityManagerInterface $em, TokenStorageInterface $tokenStorage): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {

            foreach ($user->getReposts() as $repost) {

                $em->remove($repost);
            }

            foreach ($user->getLikes() as $like) {

                $em->remove($like);
            }

            foreach ($user->getPosts() as $post) {

                foreach ($post->getReposts() as $repost) {

                    $em->remove($repost);
                }

                $em->remove($post);
            }

            $em->remove($user);
            $em->flush();

            $this->addFlash('success', 'Le compte et ses données associées ont bien été supprimés');

            $userOnline = $tokenStorage->getToken()?->getUser();
            if ($userOnline instanceof User && $userOnline->getId() === $user->getId()) {

                $tokenStorage->setToken(null);
                $request->getSession()->invalidate();
            }
        } else {

            $this->addFlash('danger', 'Jeton CSRF invalide');
        }

        return $this->redirectToRoute('admin');
    }
}
