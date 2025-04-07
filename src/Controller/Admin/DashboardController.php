<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\Repost;
use App\Entity\Comment;
use App\Entity\Report;
use App\Entity\Like;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function index(): Response
    {

        $userCount = $this->entityManager->getRepository(User::class)->count([]);
        $reportCount = $this->entityManager->getRepository(Report::class)->count([]);


        return $this->render('admin/dashboard.html.twig', [
            'userCount' => $userCount,
            'reportCount' => $reportCount,
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
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Reports', 'fas fa-reports', Report::class);
        yield MenuItem::linkToCrud('Posts', 'fas fa-posts', Post::class);
        yield MenuItem::linkToCrud('Reposts', 'fas fa-reposts', Repost::class);
        yield MenuItem::linkToCrud('Comments', 'fas fa-comments', Comment::class);
        yield MenuItem::linkToCrud('Likes', 'fas fa-likes', Like::class);
    }
}
