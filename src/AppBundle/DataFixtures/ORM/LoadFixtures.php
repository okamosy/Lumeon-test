<?php
/**
 * User: Seiji Okamoto
 * Date: 29/01/2017
 * Time: 16:33
 */

namespace AppBundle\DataFixtures\Orm;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    public function load( ObjectManager $manager )
    {
        $objects = Fixtures::load( __DIR__ . '/fixtures.yml', $manager );
    }
}
