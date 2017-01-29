<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @Route("/{patientId}")
     */
    public function ShowAction( $patientId = 0 )
    {
        return new JsonResponse();
    }

    /**
     * @Route("/add")
     */
    public function AddAction()
    {
        return $this->render('AppBundle:Patient:add.html.twig', array(
            // ...
        ));
    }

}
