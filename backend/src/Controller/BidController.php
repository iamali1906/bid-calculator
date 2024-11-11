<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BidController extends AbstractController
{
    /**
     * @Route("/api/calculate", methods={"POST"})
     */
    public function calculate(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['price']) || !isset($data['type'])) {
            return new JsonResponse([
                'error' => 'Both price and type fields are required.'
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        if (!is_numeric($data['price']) || $data['price'] <= 0) {
            return new JsonResponse([
                'error' => 'The price must be a positive number.'
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        $type = strtolower($data['type']);
        if ($type !== 'common' && $type !== 'luxury') {
            return new JsonResponse([
                'error' => 'The type must be either "common" or "luxury".'
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        $price = $data['price'];

        $buyerFee = 0;
        $specialFee = 0;
        $associationFee = 0;
        $storageFee = 100;

        if ($type === 'common') {
            $buyerFee = min(max(0.1 * $price, 10), 50);
            $specialFee = 0.02 * $price; // 2% for common
        } elseif ($type === 'luxury') {
            $buyerFee = min(max(0.1 * $price, 25), 200);
            $specialFee = 0.04 * $price; // 4% for luxury
        }

        if ($price > 3000) {
            $associationFee = 20;
        } elseif ($price > 1000) {
            $associationFee = 15;
        } elseif ($price > 500) {
            $associationFee = 10;
        } else {
            $associationFee = 5;
        }
        
        $totalCost = $price + $buyerFee + $specialFee + $associationFee + $storageFee;

        return new JsonResponse([
            'basePrice' => $price,
            'buyerFee' => $buyerFee,
            'specialFee' => $specialFee,
            'associationFee' => $associationFee,
            'storageFee' => $storageFee,
            'totalCost' => $totalCost
        ]);
    }
}
