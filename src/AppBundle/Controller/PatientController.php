<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class PatientController
 *
 * @package AppBundle\Controller
 *
 * @Route("/patient")
 */
class PatientController extends Controller
{
    /**
     * @Route("/view/{patientId}")
     *
     * @param int $patientId
     *
     * @return JsonResponse
     */
    public function ShowAction( $patientId = 0 )
    {
        $patientRepo = $this->getDoctrine()->getRepository( 'AppBundle:Patient' );

        $patient = $patientRepo->selectById( $patientId );
        if( empty( $patient ) )
        {
            return new JsonResponse(
                [
                    'message' => 'The specified patient could not be found',
                ],
                404
            );
        }

        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, [ new JsonEncoder() ] );
        return new JsonResponse(
            $serializer->serialize( $patient, 'json' )
        );
    }

    /**
     * @Route("/add")
     * @Method({"POST"})
     */
    public function AddAction()
    {
        return new JsonResponse();
    }

}
