<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Doctor;
use AppBundle\Entity\Patient;
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

    public function testAssignInvalidPatientValidDoctor()
    {
        $client = static::createClient();
        $client->request( 'POST', '/doctor/assign/1/0' );

        $response = $client->getResponse();
        $responseData = json_decode( $response->getContent() );

        $this->assertEquals( 404, $response->getStatusCode() );
        $this->assertEquals( 'Patient not found', $responseData->msg );

    }

    public function testAssignPatientDoctorReturnsDoctor()
    {
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, [ new JsonEncoder() ] );

        $client = static::createClient();
        $client->request( 'POST', '/doctor/assign/1/1' );

        $response = $client->getResponse();
        $this->assertEquals( 200, $response->getStatusCode() );

        $responseDoctor = $serializer->deserialize( json_decode( $response->getContent() ), Doctor::class, 'json' );

        $client->request( 'GET', '/doctor/view/1' );
        $this->assertEquals( 200, $client->getResponse()->getStatusCode() );
        $baseDoctor = $serializer->deserialize( json_decode( $client->getResponse()->getContent() ), Doctor::class, 'json' );
        $this->assertEquals( $baseDoctor, $responseDoctor );
    }

    public function testAssignPatientDoctorAssignmentList()
    {
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, [ new JsonEncoder() ] );

        $client = static::createClient();

        $client->request( 'GET', '/patient/view/1' );
        $this->assertEquals( 200, $client->getResponse()->getStatusCode() );
        $patient = $serializer->deserialize( json_decode( $client->getResponse()->getContent() ), Patient::class, 'json' );

        $client->request( 'POST', '/doctor/assign/1/1' );

        $response = $client->getResponse();
        $this->assertEquals( 200, $response->getStatusCode() );

        $responseDoctor = $serializer->deserialize( json_decode( $response->getContent() ), Doctor::class, 'json' );

        $this->assertAttributeContains( $patient, 'patients', $responseDoctor );
    }
}
