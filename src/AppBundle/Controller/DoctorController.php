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
        $doctor = $this->getDoctrine()->getRepository( 'AppBundle:Doctor' )->selectById( $doctorId );

        if( empty( $doctor ) ) {
            return new JsonResponse( [ 'message' => 'Doctor not found' ], 404 );
        }
        return new JsonResponse();
    }

}
