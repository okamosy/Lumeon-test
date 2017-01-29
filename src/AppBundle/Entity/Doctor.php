<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Doctor
 *
 * @ORM\Table(name="doctor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DoctorRepository")
 */
class Doctor
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
     * @var Hospital
     *
     * @ORM\ManyToOne(targetEntity="Hospital", inversedBy="doctors")
     * @ORM\JoinColumn(name="hospitalId", referencedColumnName="id")
     */
    private $hospital;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Patient", mappedBy="doctor")
     */
    private $patients;

    public function __construct( $id = 0, $name = '', $hospital = null, $patients = null )
    {
        $this->id = $id;
        $this->name = $name;
        $this->hospital = $hospital;
        $this->setPatients( $patients );
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return Doctor
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the Hospital
     *
     * @param $hospital
     * @return Doctor
     */
    public function setHospital( $hospital )
    {
        $this->hospital = $hospital;

        return $this;
    }

    /**
     * Get the Hospital.
     *
     * @return mixed
     */
    public function getHospital()
    {
        return $this->hospital;
    }

    /**
     * Sets the entire patients list
     *
     * @param $patients
     *
     * @return Doctor
     */
    public function setPatients( $patients )
    {
        if( is_array( $patients ) )
        {
            $patients = new ArrayCollection( $patients );
        }
        elseif( $patients instanceof Patient )
        {
            $patients = new ArrayCollection( [ $patients ] );
        }
        else
        {
            $patients = new ArrayCollection();
        }

        $this->patients = $patients;

        return $this;
    }

    /**
     * Add patient to list.
     *
     * @param Patient $patient
     *
     * @return Doctor
     */
    public function addPatient( Patient $patient )
    {
        $this->patients->set( $patient->getId(), $patient );

        return $this;
    }

    /**
     * Remove the specified patient from the list.
     *
     * @param $patientId
     *
     * @return bool|Patient
     */
    public function removePatient( $patientId )
    {
        $result = false;

        if( $this->patients->containsKey( $patientId ) )
        {
            $result = $this->patients->remove( $patientId );
        }

        return $result;
    }

    /**
     * Remove all patients.
     *
     * @return bool
     */
    public function removeAllPatients()
    {
        $this->patients->clear();

        return true;
    }

    /**
     * Fetches the patient.
     *
     * @param $patientId
     *
     * @return bool|Patient
     */
    public function getPatient( $patientId )
    {
        $result = false;

        if( $this->patients->containsKey( $patientId ) )
        {
            $result = $this->patients->get( $patientId );
        }

        return $result;
    }

    /**
     * Returns a list of patients.
     * 
     * @return ArrayCollection
     */
    public function getPatients()
    {
        return $this->patients;
    }
}
