<?php

namespace App\Controller\Admin;


use App\Entity\Branch;
use App\Entity\Product;
use App\Entity\Visitor;
use App\Entity\PlayDate;
use App\Entity\Schedule;
use App\Controller\Admin\BranchCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\PlayDateCrudController;
use App\Entity\PlayDateVisitor;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);        
        return $this->redirect($adminUrlGenerator->setController(PlayDateCrudController::class)->generateUrl());
        
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Playtica Administrador');
    }

    public function configureMenuItems(): iterable
    {            
        yield MenuItem::subMenu('Crear una cita de juego', 'fas fa-dice')->setCssClass('btn-reservation-submenu');
        yield MenuItem::section('');

        yield MenuItem::linkToCrud('Visitantes', 'fas fa-child', Visitor::class);
        yield MenuItem::linkToCrud('Citas de juego', 'fas fa-puzzle-piece', PlayDate::class);
        yield MenuItem::linkToCrud('Sucursales', 'fas fa-warehouse', Branch::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Horarios', 'fas fa-clock', Schedule::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Productos', 'fas fa-socks', Product::class)->setPermission('ROLE_ADMIN');
                

        yield MenuItem::section('');
        yield MenuItem::linkToLogout('Cerrar sesión', 'fas fa-sign-out-alt');
    }
}
