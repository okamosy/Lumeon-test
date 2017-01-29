<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Doctor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
     * @param Doctor $doctor
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ShowAction( Doctor $doctor )
    {
        return $this->render('AppBundle:Doctor:show.html.twig', array(
            // ...
        ));
    }

}
