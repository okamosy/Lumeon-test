<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Doctor;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
        $client = static::createClient();
        $client->request( 'GET', '/doctor/1' );
        $response = $client->getResponse();

        $doctor = new Doctor( 1, 'Test Doctor' );
        $this->assertEquals( 200, $response->getStatusCode() );
        $this->assertJsonStringEqualsJsonString( json_encode( $doctor ), $response->getContent() );
    }
}
