<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Patient;
use Doctrine\ORM\EntityRepository;

class PatientRepository extends EntityRepository implements RepositoryInterface
{
    /**
     * @param $id
     *
     * @return bool|Patient
     */
    public function selectById( $id )
    {
        $result = $this->getEntityManager()
                       ->createQuery( 'SELECT p from AppBundle:Patient p WHERE p.id = :id' )
                       ->setParameter( 'id', $id )
                       ->getResult();

        if( empty( $result[0] ) )
        {
            return false;
        }

        return $result[0];
    }

    /**
     * @param \AppBundle\Entity\Hospital $hospital
     *
     * @return Patient[]
     */
    public function selectByHospital( $hospital )
    {
    }
}