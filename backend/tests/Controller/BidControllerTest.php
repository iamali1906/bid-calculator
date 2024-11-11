<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BidControllerTest extends WebTestCase
{
    public function testCommonVehicleCalculation()
    {
        $client = static::createClient();
        $client->request('POST', '/api/calculate', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'price' => 1000,
            'type' => 'common'
        ]));

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);

        // Assertions on response data
        $this->assertEquals(1000, $responseData['basePrice']);
        $this->assertEquals(50, $responseData['buyerFee']);
        $this->assertEquals(20, $responseData['specialFee']);
        $this->assertEquals(10, $responseData['associationFee']);
        $this->assertEquals(100, $responseData['storageFee']);
        $this->assertEquals(1180, $responseData['totalCost']);
    }

    public function testLuxuryVehicleCalculation()
    {
        $client = static::createClient();
        $client->request('POST', '/api/calculate', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'price' => 4000,
            'type' => 'luxury'
        ]));

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);

        // Assertions on response data
        $this->assertEquals(4000, $responseData['basePrice']);
        $this->assertEquals(200, $responseData['buyerFee']);
        $this->assertEquals(160, $responseData['specialFee']);
        $this->assertEquals(20, $responseData['associationFee']);
        $this->assertEquals(100, $responseData['storageFee']);
        $this->assertEquals(4480, $responseData['totalCost']);
    }
}
