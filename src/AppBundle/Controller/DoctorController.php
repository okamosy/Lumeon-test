<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Doctor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DoctorController
 *
 * @package AppBundle\Controller
 *
 * @Route("/doctor")
 */
class DoctorController extends Controller
{
    /**
     * @Route("/{id}")
     *
     * @param int doctorId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ShowAction( $doctorId = 0)
    {
        try {
            return new JsonResponse();
        }
        catch( \Exception $e )
        {

        }
    }

}
