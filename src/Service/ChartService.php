<?php

namespace App\Service;

use App\Config\Bike\Status as BikeStatus;
use App\Repository\BikeRepository;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

/**
 * Description of ChartService
 *
 * @author bgamrat
 */
class ChartService {

    public function __construct(
            private ChartBuilderInterface $chartBuilder,
            private BikeRepository $bikeRepository) {

    }

    public function makeBikeChart() {
        $bikeChart = $this->chartBuilder->createChart(Chart::TYPE_BAR);
        $bikeStatuses = [BikeStatus::Received,
            BikeStatus::InProgress,
            BikeStatus::ReadyForClient,
            BikeStatus::ReadyForSale];
        $data = [];
        foreach ($bikeStatuses as $status) {
            $data[] = $this->bikeRepository->countByStatus([$status]);
        }
        $bikeChart->setData([
            'labels' => $bikeStatuses,
            'datasets' => [[
            'label' => 'Bikes',
            'data' => $data
                ]]
        ]);
        $bikeChart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => max($data) * 1.1,
                ],
            ],
        ]);
        return $bikeChart;
    }
}
