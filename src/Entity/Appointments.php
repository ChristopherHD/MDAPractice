<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @property \DateTimeInterface datetime
 * @ORM\Entity(repositoryClass="App\Repository\AppointmentsRepository")
 */
class Appointments
{

    public function __construct($patient=null, $doctor=null, $date=null, $description="Ninguna", $animal=null)
    {
        $this->patient = $patient;
        $this->doctor = $doctor;
        $this->date = $date;
		$this->description = $description;
		$this->animal = $animal;
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
     * @var Animals $animal
     * @ORM\ManyToOne(targetEntity="App\Entity\Animals")
     * @ORM\JoinColumn(name="animal", referencedColumnName="id")
     */
    private $animal;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;
	
    /**
     * @ORM\Column(type="string", length=200 )
     */
    private $description;

    /**
     * @ORM\Column(type="boolean",options={"default": "0"})
     */
    private $isClosed = false;

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
	
	public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Animals
     */
    public function getAnimal(): ?Animals
    {
        return $this->animal;
    }

    /**
     * @param Animals $animal
     */
    public function setAnimal(Animals $animal): void
    {
        $this->animal = $animal;
    }

    /**
     * @return mixed
     */
    public function getisClosed()
    {
        return $this->isClosed;
    }

    /**
     * @param mixed $isClosed
     */
    public function setIsClosed($isClosed): void
    {
        $this->isClosed = $isClosed;
    }
}
