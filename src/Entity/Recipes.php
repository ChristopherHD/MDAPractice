<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @property \DateTimeInterface datetime
 * @ORM\Entity(repositoryClass="App\Repository\AppointmentsRepository")
 */
class Recipes
{

    public function __construct($patient=null, $doctor=null, $date=null, $name=null)
    {
        $this->patient = $patient;
        $this->doctor = $doctor;
        $this->date = $date;
		$this->name = $name;

    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Users $patient
	 * @ORM\ManyToOne(targetEntity="Users")
	 * @ORM\JoinColumn(name="patient", referencedColumnName="dni")
     */
    private $patient;

    /**
     * @var Doctors $doctor
	 * @ORM\ManyToOne(targetEntity="Doctors")
	 * @ORM\JoinColumn(name="doctor", referencedColumnName="dni")
     */
    private $doctor;


    /**
     * @ORM\Column(type="datetime")
     */
    private $date;
	
    /**
     * @ORM\Column(type="string", length=20 )
     */
    private $name;

    public function getId()
    {
        return $this->id;
    }

    public function getPatient(): ?Users
    {
        return $this->patient;
    }

    public function setPatient(Users $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getDoctor(): ?Doctors
    {
        return $this->doctor;
    }

    public function setDoctor(Doctors $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDatetime(\DateTimeInterface $date): self
    {
        $this->datetime = $date;

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
     */
    public function setName($name): void
    {
        $this->name = $name;
    }


}
