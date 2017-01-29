<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PatientControllerTest extends WebTestCase
{
    public function testShowJsonResponse()
    {
        $client = static::createClient();

        $client->request('GET', '/patient/1');

        $this->assertJson( $client->getResponse()->getContent() );

    }

    public function testShowJsonMissingPatient()
    {
        $client = static::createClient();

        $client->request( 'GET', '/patient/1000' );

        $this->assertEquals( 404, $client->getResponse()->getStatusCode() );
    }

    public function testShowJsonValidPatient()
    {
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, [ new JsonEncoder() ] );

        $patient = new Patient( 1, 'John Doe', new \DateTime( '2000-01-01' ), 'male' );

        $client = static::createClient();
        $client->request( 'GET', '/patient/1' );

        $response = $client->getResponse();

        $this->assertEquals( 200, $response->getStatusCode() );
        
        $responsePatient = $serializer->deserialize( json_decode($response->getContent()), Patient::class, 'json' );

        $this->assertEquals( $patient, $responsePatient );

    }

    // public function testAdd()
    // {
    //     $client = static::createClient();
    //
    //     $crawler = $client->request('GET', 'add');
    // }

}
