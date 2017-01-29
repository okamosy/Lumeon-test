<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Doctor;
use AppBundle\Entity\Patient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
     * @Route("/view/{doctorId}")
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

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function( $object )
        {
            return $object->getName();
        } );

        $serializer = new Serializer([ $normalizer ], [ new JsonEncoder() ] );

        return new JsonResponse(
                $serializer->serialize( $doctor, 'json' )
        );
    }

    /**
     * @Route("/assign/{doctorId}/{patientId}")
     * @Method({"POST"})
     *
     * @param int $doctorId
     * @param int $patientId
     *
     * @return JsonResponse
     */
    public function AssignAction( $doctorId = 0, $patientId = 0 )
    {
        /** @var Doctor $doctor */
        $doctor = $this->getDoctrine()->getRepository( 'AppBundle:Doctor' )->selectById( $doctorId );
        if( empty( $doctor ) ) {
            return new JsonResponse(
                [
                    'msg' => 'Doctor not found'
                ],
                 404
            );
        }

        /** @var Patient $patient */
        $patient = $this->getDoctrine()->getRepository( 'AppBundle:Patient' )->selectById( $patientId );
        if( empty( $patient ) ) {
            return new JsonResponse(
                [
                    'msg' => 'Patient not found'
                ],
                404
            );
        }

        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, [ new JsonEncoder() ] );

        return new JsonResponse(
            $serializer->serialize( $doctor, 'json' )
        );
    }
}
