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

use App\Entity\Agency;
use App\Entity\Bike;
use App\Entity\BikeRequest;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController {

    public function __construct(
            //  private ChartBuilderInterface $chartBuilder,
    ) {
        
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response {
        // TODO: add charts
        //$bikeChart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        //$bikeRequestChart = $this->chartBuilder->createChart(Chart::TYPE_GEAR);
        return $this->render('admin/dashboard.html.twig'); //,['bike_chart' => $bikeChart, 'bike_request_chart' => $bikeRequestChart]);
    }

    public function configureDashboard(): Dashboard {
        return Dashboard::new()
                        ->setTitle('Open Bike');
    }

    public function configureMenuItems(): iterable {
        yield MenuItem::linkToRoute('Home', 'fas fa-home', 'home');
        yield MenuItem::linkToDashboard('Dashboard', 'fas fa-gauge');
        yield MenuItem::linkToCrud('Bikes', 'fas fa-bicycle', Bike::class);
        yield MenuItem::linkToCrud('Bike Requests', 'fas fa-calendar', BikeRequest::class);
        yield MenuItem::linkToCrud('Agencies', 'fas fa-building', Agency::class);
    }
}
