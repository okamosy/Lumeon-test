<?php

namespace AppBundle\Tests\Controller;

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
}
