<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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

    // public function testAdd()
    // {
    //     $client = static::createClient();
    //
    //     $crawler = $client->request('GET', 'add');
    // }

}
