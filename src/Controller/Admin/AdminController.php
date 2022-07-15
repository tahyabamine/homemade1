<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Genre;
use App\Entity\Region;
use App\Entity\Categorie;
use App\Entity\Specialite;
use App\Controller\Admin\GenreCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\CategorieCrudController;
use App\Entity\Annonce;
use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class AdminController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
       

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
    $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
     return $this->redirect($adminUrlGenerator->setController(CategorieCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Homemade');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
         yield MenuItem::linkToCrud('Genre', 'fas fa-list', Genre::class);
         yield MenuItem::linkToCrud('Region', 'fas fa-list', Region::class);
         yield MenuItem::linkToCrud('Specialite', 'fas fa-list', Specialite::class);
         yield MenuItem::linkToCrud('categorie', 'fas fa-list', Categorie::class);
         yield MenuItem::linkToCrud('user', 'fas fa-list', User::class);
         yield MenuItem::linkToCrud('user', 'fas fa-list', Annonce::class);
         yield MenuItem::linkToCrud('user', 'fas fa-list', Commentaire::class);
    }
}
