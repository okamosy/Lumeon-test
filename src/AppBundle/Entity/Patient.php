<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Patient
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="patient")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PatientRepository")
 */
class Patient
{
    const GENDER_MALE   = 1;
    const GENDER_FEMALE = 2;
    const GENDER_OTHER  = 3;

    private $genderList = [
        self::GENDER_MALE   => 'male',
        self::GENDER_FEMALE => 'female',
        self::GENDER_OTHER  => 'other',
    ];

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
     * @var  \DateTime
     *
     * @ORM\Column(name="dob", type="date")
     */
    private $dob;

    /**
     * @var  string
     *
     * @ORM\Column(name="gender", type="string", length=10))
     */
    private $gender;

    /**
     * @var  Hospital
     *
     * @ORM\ManyToOne(targetEntity="Hospital", inversedBy="patients")
     * @ORM\JoinColumn(name="hospitalId", referencedColumnName="id")
     */
    private $hospital = null;

    /**
     * @var Doctor
     *
     * @ORM\ManyToOne(targetEntity="Doctor", inversedBy="patients")
     * @ORM\JoinColumn(name="doctorId", referencedColumnName="id")
     */
    private $doctor = null;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Patient
     */
    public function setId( $id )
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Patient
     */
    public function setName( $name )
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @param \DateTime $dob
     *
     * @return Patient
     */
    public function setDob( $dob )
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     *
     * @return Patient
     */
    public function setGender( $gender )
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Hospital
     */
    public function getHospital()
    {
        return $this->hospital;
    }

    /**
     * @param Hospital $hospital
     *
     * @return Patient
     */
    public function setHospital( $hospital )
    {
        $this->hospital = $hospital;

        return $this;
    }

    /**
     * Sets the current doctor.
     *
     * @param Doctor $doctor
     *
     * @return Patient
     */
    public function setDoctor( Doctor $doctor )
    {
        $this->doctor = $doctor;

        return $this;
    }

    /**
     * Gets the current doctor.
     *
     * @return null|Doctor
     */
    public function getDoctor()
    {
        return $this->doctor;
    }
}
