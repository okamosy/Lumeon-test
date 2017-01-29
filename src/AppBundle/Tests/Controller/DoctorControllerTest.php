<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Doctor;
use AppBundle\Entity\Patient;
use Doctrine\Common\Collections\ArrayCollection;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DoctorControllerTest extends WebTestCase
{
    /** @var   */
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

    protected function assertDoctor( Doctor $expected, Doctor $actual )
    {
        $this->assertEquals( $expected->getName(), $actual->getName() );
        $this->assertEquals( $expected->getId(), $actual->getId() );
        $this->assertEquals( $expected->getHospital(), $actual->getHospital() );
    }

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
        $responseData = json_decode( $response->getContent() );

        $this->assertEquals(404, $response->getStatusCode() );
        $this->assertEquals( 'Doctor not found', $responseData->msg );
    }

    public function testShowJsonDoctor()
    {
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, [ new JsonEncoder() ] );

        $client = static::createClient();
        $client->request( 'GET', '/doctor/view/1' );
        $response = $client->getResponse();

        $this->assertEquals( 200, $response->getStatusCode() );

        /** @var Doctor $responseDoctor */
        $responseDoctor = $serializer->deserialize( json_decode($response->getContent()), Doctor::class, 'json' );
        $this->assertDoctor(  $this->fixtures['doctor1'], $responseDoctor );
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

        $this->assertDoctor( $this->fixtures['doctor1'], $responseDoctor );
    }

    public function testAssignPatientDoctorAssignmentList()
    {
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, [ new JsonEncoder() ] );

        $client = static::createClient();

        /** @var Patient $patient */
        $patient = $this->fixtures['patient1'];

        $client->request( 'POST', '/doctor/assign/1/1' );

        $response = $client->getResponse();
        $this->assertEquals( 200, $response->getStatusCode() );

        $responseDoctor = $serializer->deserialize( json_decode( $response->getContent() ), Doctor::class, 'json' );

        /** @var ArrayCollection $patientList */
        $patientList = $responseDoctor->getPatients();
        $this->assertEquals( 2, $patientList->count() );

        $addedPatient = $responseDoctor->getPatient( $patient->getId() );
        $this->assertEquals( $patient->getId(), $addedPatient['id'] );
        $this->assertEquals( $patient->getName(), $addedPatient['name'] );
    }
}
