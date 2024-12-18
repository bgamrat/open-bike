<?php

namespace App\Service;

use App\Config\BikeRequest\Status as BikeRequestStatus;
use App\Config\Bike\Status as BikeStatus;
use App\Repository\BikeRepository;
use App\Repository\BikeRequestRepository;
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
            private BikeRepository $bikeRepository,
            private BikeRequestRepository $bikeRequestRepository) {

    }

    public function makeBikeStatusChart() {
        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);
        $bikeStatuses = [BikeStatus::Received,
            BikeStatus::InProgress,
            BikeStatus::ReadyForClient,
            BikeStatus::ReadyForSale];
        $data = [];
        foreach ($bikeStatuses as $status) {
            $data[] = $this->bikeRepository->countByStatus([$status]);
        }
        $chart->setData([
            'labels' => $bikeStatuses,
            'datasets' => [[
            'label' => 'Bikes',
            'data' => $data
                ]]
        ]);
        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => max($data) * 1.1,
                ],
            ],
           'plugins'=>['autocolors' => ['mode' => 'data']]
        ]);
        return $chart;
    }

    public function makeBikeRequestChart() {
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        $labels = [];
        foreach (BikeRequestStatus::cases() as $s) {
            $bikeRequestStatus[] = $s->value;
        }
        $datasets = array_fill_keys($bikeRequestStatus,['label' => '','data' => []]);
        foreach ($datasets as $k => $ds) {
            $datasets[$k]['label'] = $k;
        }
        $data = $this->bikeRequestRepository->countByStatusGroupByYearMonth();
        $firstDate = new \DateTime($data[0]['yearmonth']);
        $lastDate = new \DateTime($data[count($data)-1]['yearmonth']);
        $datePeriod = new \DatePeriod($firstDate,new \DateInterval('P1M'),$lastDate->add(new \DateInterval('P1D')));
        foreach ($datePeriod as $date) {
            $dateString = $date->format('Y-M');
            $labels[] = $dateString;
            foreach ($bikeRequestStatus as $s) {
                $datasets[$s]['assoc-data'][$dateString] = 0;
            }
        }
        foreach ($data as $d) {
            $datasets[$d['status']]['assoc-data'][$d['yearmonth']] = $d['cnt'];
        }
        $arr = [];
        foreach ($datasets as $s => $ds) {
            $arr[] = ['label' => $s, 'data' => array_values($ds['assoc-data'])];
            unset($datasets[$s]);
        }
        $chart->setData([
            'labels' => $labels,
            'datasets' => $arr
        ]);
        $chart->setOptions(['plugins'=>['autocolors' => ['mode' => 'dataset']]]);
        return $chart;
    }
}
