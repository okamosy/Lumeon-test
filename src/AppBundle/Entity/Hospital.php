<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Hospital
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="hospital")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HospitalRepository")
 */
class Hospital
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * A hospital can have many doctors
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Doctor", mappedBy="hospital")
     */
    private $doctors;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Patient", mappedBy="hospital")
     */
    private $patients;

    public function __construct()
    {
        $this->doctors  = new ArrayCollection();
        $this->patients = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Hospital
     */
    public function setId( $id )
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return Hospital
     */
    public function setName( $name )
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the entire list of Doctors.
     *
     * @param ArrayCollection $doctors
     *
     * @return Hospital
     */
    public function setDoctors( ArrayCollection $doctors )
    {
        $this->doctors = $doctors;

        return $this;
    }

    /**
     * Get the entire list of Doctors.
     *
     * @return ArrayCollection
     */
    public function getDoctors()
    {
        return $this->doctors;
    }

    /**
     * Remove all Doctors.
     *
     * @return bool
     */
    public function removeDoctors()
    {
        $this->doctors->clear();

        return true;
    }

    /**
     * Add a Doctor to the list.
     *
     * @param Doctor $doctor
     *
     * @return Hospital
     */
    public function addDoctor( Doctor $doctor )
    {
        $this->doctors->set( $doctor->getId(), $doctor );

        return $this;
    }

    /**
     * Gets the Doctor.
     *
     * @param $doctorId
     *
     * @return bool|Doctor
     */
    public function getDoctor( $doctorId )
    {
        $result = false;

        if( $this->doctors->containsKey( $doctorId ) )
        {
            $result = $this->doctors->get( $doctorId );
        }

        return $result;
    }

    /**
     * Remove the Doctor.
     *
     * @param $doctorId
     *
     * @return bool|Doctor
     */
    public function removeDoctor( $doctorId )
    {
        $result = false;

        if( $this->doctors->containsKey( $doctorId ) )
        {
            $result = $this->doctors->remove( $doctorId );
        }

        return $result;
    }

}
