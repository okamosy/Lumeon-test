<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Patient;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PatientControllerTest extends WebTestCase
{
    protected $fixtures;

    protected function setUp()
    {
        parent::setUp();

        $this->fixtures = $this->loadFixtureFiles(
            [
                '@AppBundle/DataFixtures/ORM/fixtures.yml',
            ]
        );
    }

    public function testShowJsonResponse()
    {
        $client = static::createClient();

        $client->request('GET', '/patient/view/1');

        $this->assertJson( $client->getResponse()->getContent() );

    }

    public function testShowJsonMissingPatient()
    {
        $client = static::createClient();

        $client->request( 'GET', '/patient/view/1000' );
        $response = $client->getResponse();
        $responseData = json_decode( $response->getContent() );

        $this->assertEquals( 404, $response->getStatusCode() );
        $this->assertEquals( 'Patient not found', $responseData->msg );
    }

    public function testShowJsonValidPatient()
    {
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, [ new JsonEncoder() ] );

        $client = static::createClient();
        $client->request( 'GET', '/patient/view/1' );

        $response = $client->getResponse();

        $this->assertEquals( 200, $response->getStatusCode() );
        
        $responsePatient = $serializer->deserialize( json_decode($response->getContent()), Patient::class, 'json' );

        $this->assertEquals( $this->fixtures['patient1'], $responsePatient );

    }

    public function testAddValidPatientStatusCode()
    {
        $client = static::createClient();

        $newPatient = [
            'name'   => 'Test Patient',
            'dob'    => '1995-07-07',
            'gender' => 'female',
        ];

        $client->request(
            'POST',
            '/patient/add',
            [], // parameters
            [],// files
            ['CONTENT_TYPE' => 'application/json'], // server
            json_encode( $newPatient )
        );

        $response = $client->getResponse();

        $this->assertEquals( 200, $response->getStatusCode() );
    }

    public function testAddValidPatientData()
    {
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, [ new JsonEncoder() ] );

        $client = static::createClient();

        $newPatient = [
            'name' => 'Test Patient',
            'dob' => '1995-07-07',
            'gender' => 'female',
        ];

        $client->request(
            'POST',
            '/patient/add',
            [], // parameters
            [],// files
            [ 'CONTENT_TYPE' => 'application/json' ], // server
            json_encode( $newPatient )
        );

        $response = $client->getResponse();

        $this->assertEquals( 200, $response->getStatusCode() );

        /** @var Patient $patient */
        $patient = $serializer->deserialize( json_decode( $response->getContent()), Patient::class, 'json' );

        // Since we don't necessarily know the ID of the new patient...test each field
        $this->assertNotEquals( 0, $patient->getId() );
        $this->assertEquals( $newPatient['name'], $patient->getName() );
        $this->assertEquals( new \DateTime( $newPatient['dob'] ), $patient->getDob() );
        $this->assertEquals( $newPatient['gender'], $patient->getGender() );
    }
}
