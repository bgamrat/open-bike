<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Entity\Bike;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController {

    #[Route('/admin', name: 'admin')]
    public function index(): Response {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard {
        return Dashboard::new()
                        ->setTitle('Open Bike');
    }

    public function configureMenuItems(): iterable {
        yield MenuItem::linkToRoute('Home', 'fas fa-home', 'home');
        yield MenuItem::linkToDashboard('Dashboard', 'fas fa-gauge');
        yield MenuItem::linkToCrud('Bikes', 'fas fa-bicycle', Bike::class);
    }
}
