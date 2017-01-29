<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
     * @Route("/{doctorId}")
     *
     * @param int $doctorId
     *
     * @return JsonResponse
     */
    public function ShowAction( $doctorId = 0)
    {
        $doctor = $this->getDoctrine()->getRepository( 'AppBundle:Doctor' )->selectById( $doctorId );

        if( empty( $doctor ) ) {
            return new JsonResponse( [ 'message' => 'Doctor ('.$doctorId.') not found' ], 404 );
        }

        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, [ new JsonEncoder() ] );
        return new JsonResponse(
                $serializer->serialize( $doctor, 'json' )
        );
    }

}
