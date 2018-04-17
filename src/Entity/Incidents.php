<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @property \DateTimeInterface datetime
 * @ORM\Entity(repositoryClass="App\Repository\IncidentsRepository")
 */
class Incidents
{

    public function __construct($patient=null, $doctor=null, $date=null, $description="Ninguna", $isClosed=false)
    {
        $this->patient = $patient;
        $this->doctor = $doctor;
        $this->date = $date;
		$this->description = $description;
		$this->isClosed = $isClosed;
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var integer $patient
	 * @ORM\ManyToOne(targetEntity="Users")
	 * @ORM\JoinColumn(name="patient", referencedColumnName="dni")
     */
    private $patient;

    /**
     * @var integer $doctor
	 * @ORM\ManyToOne(targetEntity="Doctors")
	 * @ORM\JoinColumn(name="doctor", referencedColumnName="dni")
     */
    private $doctor;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;
	
    /**
     * @ORM\Column(type="string", length=200 )
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isClosed;

    public function getId()
    {
        return $this->id;
    }

    public function getPatient(): ?int
    {
        return $this->patient;
    }

    public function setPatient(int $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getDoctor(): ?int
    {
        return $this->doctor;
    }

    public function setDoctor(int $doctor): self
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
	
	public function getDescription(): ?string
    {
        return $this->doctor;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
