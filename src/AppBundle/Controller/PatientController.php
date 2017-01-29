<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
     * @Route("/")
     */
    public function ShowAction()
    {
        return $this->render('AppBundle:Patient:show.html.twig', array(
            // ...
        ));
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
