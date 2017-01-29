<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * DoctorRepository
 */
class DoctorRepository extends EntityRepository implements RepositoryInterface
{
    public function selectById( $id )
    {
        $result = $this->getEntityManager()
                    ->createQuery( 'SELECT d from AppBundle:Doctor d WHERE d.id = :id' )
                    ->setParameter( 'id', $id )
                    ->getResult();

        if( empty( $result[0] ) )
        {
            return false;
        }

        return $result[0];
    }
}
