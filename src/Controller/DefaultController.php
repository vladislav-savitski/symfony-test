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
     * @return Response
     */
    public function appDefaultAction(): Response
    {
        $vehicles = $this->doctrineVehicles->findBy([], null, 12, 1);
        $energies = $this->doctrineVehicles->findAllEnergy();
        return $this->render('app/auto.html.twig', ['vehicles' => $vehicles, 'energies' => $energies]);
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

        $budget = $request->get('budget', null);
        if ($budget) {
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
        $mark = $request->get('mark', null);
        if ($mark) {
            $criteria->andWhere($expr->gte('brand', $mark));
        }
        $energy = $request->get('energy', null);
        if ($energy) {
            $criteria->andWhere($expr->gte('energy', $energy));
        }
        $orderBy = $request->get('order_by', null);
        if ($orderBy) {
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

        $criteria->setMaxResults(12);
        $vehicles = $this->doctrineVehicles->matching($criteria);
        $energies = $this->doctrineVehicles->findAllEnergy();
        return $this->render('app/auto.html.twig', [
            'vehicles' => $vehicles,
            'ready_to_go' => $readyToGo,
            'zero_km' => $zeroKm,
            'promotions' => $promotions,
            'budget' => $budget,
            'mark' => $mark,
            'energies' => $energies
        ]);
    }
}