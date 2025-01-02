<?php

/* TODO: Add localization support */

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Config\Bike\Status as BikeStatus;
use App\Config\BikeRequest\Status as BikeRequestStatus;
use App\Entity\Agency;
use App\Entity\Bike;
use App\Entity\BikeRequest;
use App\Entity\Contact;
use App\Entity\Document;
use App\Entity\Event;
use App\Entity\Gallery;
use App\Entity\Page;
use App\Entity\Shift;
use App\Entity\Volunteer;
use App\Repository\BikeRepository;
use App\Repository\BikeRequestRepository;
use App\Repository\ShiftRepository;
use App\Repository\VolunteerRepository;
use App\Service\ChartService;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController {

    public function __construct(
            private ChartService $chartService,
            private BikeRepository $bikeRepository,
            private BikeRequestRepository $bikeRequestRepository,
            private VolunteerRepository $volunteerRespository,
            private ShiftRepository $shiftRepository
    ) {
        
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response {
        $bikeStatusChart = $this->chartService->makeBikeStatusChart();
        $bikeStatusAllChart = $this->chartService->makeBikeStatusAllChart();
        $totalVolunteerHours = $this->shiftRepository->countHours()['total'] / 3600;
        $volunteerHoursChart = $this->chartService->makeVolunteerHoursChart();
        $bikeRequestChart = $this->chartService->makeBikeRequestChart();
        $bikeRequests = $this->bikeRequestRepository->countByStatus([BikeRequestStatus::Pending]);
        $bikesReadyForClients = $this->bikeRepository->countByStatus([BikeStatus::ReadyForClient]);
        $volunteers = $this->volunteerRespository->count();
        $totalBikes = $this->bikeRepository->count();
        return $this->render('admin/dashboard.html.twig', [
                    'bike_status_chart' => $bikeStatusChart,
                    'bike_status_all_chart' => $bikeStatusAllChart,
                    'bike_requests' => $bikeRequests,
                    'bike_request_chart' => $bikeRequestChart,
                    'volunteers' => $volunteers,
                    'total_volunteer_hours' => $totalVolunteerHours,
                    'total_bikes' => $totalBikes,
                    'bikes_ready_for_clients' => $bikesReadyForClients,
                    'volunteer_hours_chart' => $volunteerHoursChart]);
    }

    public function configureDashboard(): Dashboard {
        return Dashboard::new()
                        ->setTitle('Open Bike');
    }

    public function configureMenuItems(): iterable {
        yield MenuItem::linkToUrl('Home', 'fas fa-home', '/');
        yield MenuItem::linkToDashboard('Dashboard', 'fas fa-gauge');
        yield MenuItem::section('Operations');
        yield MenuItem::linkToCrud('Bikes', 'fas fa-bicycle', Bike::class);
        yield MenuItem::linkToCrud('Volunteers', 'fas fa-person', Volunteer::class);
        yield MenuItem::linkToCrud('Shifts', 'fas fa-business-time', Shift::class);
        yield MenuItem::linkToCrud('Events', 'fas fa-calendar', Event::class);
        yield MenuItem::linkToCrud('Contacts', 'fas fa-envelope', Contact::class);
        yield MenuItem::section('Clients');
        yield MenuItem::linkToCrud('Bike Requests', 'fas fa-hand-pointer', BikeRequest::class);
        yield MenuItem::linkToCrud('Agencies', 'fas fa-building', Agency::class);
        yield MenuItem::section('Content');
        yield MenuItem::linkToCrud('Pages', 'fas fa-file-text', Page::class);
        yield MenuItem::linkToCrud('Documents', 'fas fa-file-pdf', Document::class);
        yield MenuItem::linkToCrud('Gallery', 'fas fa-images', Gallery::class);
    }
}
