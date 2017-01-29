<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Doctor;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DoctorControllerTest extends WebTestCase
{
    public function testShowJsonResponse()
    {
        $client = static::createClient();

        $client->request('GET', '/doctor/1');
        $response = $client->getResponse();
        $this->assertJson( $response->getContent() );
    }

    public function testShowJsonMissingDoctor()
    {
        $client = static::createClient();

        $client->request( 'GET', '/doctor/1234' );
        $response = $client->getResponse();

        $this->assertEquals(404, $response->getStatusCode() );
    }

    public function testShowJsonDoctor()
    {
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, [ new JsonEncoder() ] );
        $doctor = new Doctor( 1, 'Test Doctor' );

        $client = static::createClient();
        $client->request( 'GET', '/doctor/1' );
        $response = $client->getResponse();

        $this->assertEquals( 200, $response->getStatusCode() );
        
        $responseDoctor = $serializer->deserialize( json_decode($response->getContent()), Doctor::class, 'json' );

        $this->assertEquals( $doctor, $responseDoctor );
    }
}
