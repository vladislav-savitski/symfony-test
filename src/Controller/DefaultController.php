<?php

namespace App\Controller;

use App\Repository\VehiclesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\Criteria;

class DefaultController extends AbstractController
{
    protected $doctrineVehicles;

    public function __construct(VehiclesRepository $doctrineVehicles)
    {
        $this->doctrineVehicles = $doctrineVehicles;
    }

    /**
     * @Route("/", name="app_home")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int $limit
     * @return Response
     */
    public function appDefaultAction(Request $request, int $limit = 12): Response
    {
        if ($page = $request->get('page', null)) {
            $vehicles = $this->doctrineVehicles->findBy([], null, $limit, ($page - 1) * $limit);
        } else {
            $vehicles = $this->doctrineVehicles->findBy([], null, $limit, 0);
        }
        $energies = $this->doctrineVehicles->findAllEnergy();
        $pages = ceil(count($this->doctrineVehicles->findAll()) / 12);
        $max = $this->doctrineVehicles->findMaxPrice();
        $min = $this->doctrineVehicles->findMinPrice();
        return $this->render('app/auto.html.twig', [
            'vehicles' => $vehicles,
            'energies' => $energies,
            'pages' => $pages,
            'max_price' => $max[0],
            'min_price' => 0
        ]);
    }

    /**
     * @Route("/filter", name="filter")
     * @return Response
     */
    public function appFilter(Request $request): Response
    {
        $expr = Criteria::expr();
        $criteria = Criteria::create();
        $readyToGo =  $request->get('ready_to_go', null);
        $readyToGo = $readyToGo ? true : false;

        $zeroKm =  $request->get('zeroKm', null);
        $zeroKm = $zeroKm ? true : false;

        $promotions =  $request->get('promotions', null);
        if ($promotions) {
            $criteria->andWhere($expr->neq('priceRetail', null));
        }

        if ($budget = $request->get('budget', null)) {
            $min = $request->get('min_price', null);
            $max = $request->get('max_price', null);
            if ($budget === 'total') {
                $criteria->andWhere($expr->gt('price', $min));
                $criteria->andWhere($expr->lt('price', $max));
            } elseif ($budget === 'mensuel') {
                $criteria->andWhere($expr->gt('priceMonthly', $min));
                $criteria->andWhere($expr->lt('priceMonthly', $max));
            }
        }

        if ($mark = $request->get('mark', null)) {
            $criteria->andWhere($expr->gte('brand', $mark));
        }

        if ($energy = $request->get('energy', null)) {
            $criteria->andWhere($expr->gte('energy', $energy));
        }

        if ($orderBy = $request->get('order_by', null)) {
            if ($orderBy === 'priceASC') {
                $criteria->orderBy(['price' => 'ASC']);
            } elseif ($orderBy === 'priceDSC') {
                $criteria->orderBy(['price' => 'DSC']);
            } elseif ($orderBy === 'brandASC') {
                $criteria->orderBy(['brand' => 'ASC']);
            } elseif ($orderBy === 'brandDSC') {
                $criteria->orderBy(['brand' => 'DSC']);
            }
        }

        $vehicles = $this->doctrineVehicles->matching($criteria);
        $energies = $this->doctrineVehicles->findAllEnergy();

        $max = $this->doctrineVehicles->findMaxPrice();
        $min = $this->doctrineVehicles->findMinPrice();
        return $this->render('app/auto.html.twig', [
            'vehicles' => $vehicles,
            'ready_to_go' => $readyToGo,
            'zero_km' => $zeroKm,
            'promotions' => $promotions,
            'budget' => $budget,
            'mark' => $mark,
            'energies' => $energies,
            'max_price' => $max[0],
            'min_price' => 0
        ]);
    }
}