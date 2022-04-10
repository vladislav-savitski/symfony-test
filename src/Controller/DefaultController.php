<?php

namespace App\Controller;

use App\Repository\VehiclesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    protected $doctrineVehicles;

    public function __construct(VehiclesRepository $doctrineVehicles)
    {
        $this->doctrineVehicles = $doctrineVehicles;
    }

    /**
     * @Route("/", name="app_home")
     * @return Response
     */
    public function appDefaultAction(): Response
    {
        $vehicles = $this->doctrineVehicles->findAll();
        return $this->render('app/auto.html.twig', ['vehicles' => $vehicles]);
    }

    /**
     * @Route("/filter", name="filter")
     * @return Response
     */
    public function appFilter(): Response
    {
//        $vehicles = $this->doctrineVehicles->findAll();
        $params = [];
        if (isset($_GET['ready_to_go']) && $_GET['ready_to_go'] === 'on') {
            $readyToGo = true;
        } else {
            $readyToGo = false;
        }
        if (isset($_GET['zero_km']) && $_GET['zero_km'] === 'on') {
            $zeroKm = true;
        } else {
            $zeroKm = false;
        }
        if (isset($_GET['promotions']) && $_GET['promotions'] === 'on') {
            $promotions = true;
        } else {
            $promotions = false;
        }
        if (isset($_GET['budget'])) {
            if ($_GET['budget'] === 'total') {
                $budget = 'total';
            } elseif ($_GET['budget'] === 'mensuel') {
                $budget = 'mensuel';
            }
        }
        if (isset($_GET['mark'])) {
            $mark = $_GET['mark'];
        }
        if (isset($_GET['vehicle_type'])) {
            $vehicle_type = $_GET['vehicle_type'];
        }
        $vehicles = $this->doctrineVehicles->findByMarkField($mark ?? '');
        return $this->render('app/auto.html.twig', [
            'vehicles' => $vehicles,
            'ready_to_go' => $readyToGo,
            'zero_km' => $zeroKm,
            'promotions' => $promotions,
            'budget' => $budget ?? '',
            'mark' => $mark ?? '',
            'vehicle_type' => $vehicle_type ?? ''
        ]);
    }
}