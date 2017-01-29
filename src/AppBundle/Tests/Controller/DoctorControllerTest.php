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

        $client->request('GET', '/doctor/view/1');
        $response = $client->getResponse();
        $this->assertJson( $response->getContent() );
    }

    public function testShowJsonMissingDoctor()
    {
        $client = static::createClient();

        $client->request( 'GET', '/doctor/view/1234' );
        $response = $client->getResponse();

        $this->assertEquals(404, $response->getStatusCode() );
    }

    public function testShowJsonDoctor()
    {
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, [ new JsonEncoder() ] );
        $doctor = new Doctor( 1, 'Test Doctor' );

        $client = static::createClient();
        $client->request( 'GET', '/doctor/view/1' );
        $response = $client->getResponse();

        $this->assertEquals( 200, $response->getStatusCode() );
        
        $responseDoctor = $serializer->deserialize( json_decode($response->getContent()), Doctor::class, 'json' );

        $this->assertEquals( $doctor, $responseDoctor );
    }

    public function testAssignPatientInvalidDoctor()
    {
        $client = static::createClient();
        $client->request( 'POST', '/doctor/assign/0/1' );

        $response = $client->getResponse();
        $responseData = json_decode( $response->getContent() );

        $this->assertEquals( 404, $response->getStatusCode() );
        $this->assertEquals( 'Doctor not found', $responseData->msg );
    }
}
