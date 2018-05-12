<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @property \DateTimeInterface datetime
 * @ORM\Entity(repositoryClass="App\Repository\IncidentsRepository")
 */
class Incidents
{

    public function __construct($date=null, $description=null, $isClosed=false,$email=null, $title=null ,$patient=null, $doctor=null)
    {
        $this->patient = $patient;
        $this->doctor = $doctor;
        $this->date = $date;
		$this->title = $title;
		$this->description = $description;
		$this->isClosed = $isClosed;
		$this->email=$email;
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
     * @ORM\Column(type="string", length=40 )
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=200 )
     */
    private $description;
	
    /**
     * @ORM\Column(type="string", length=200 )
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isClosed;

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
	
	public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
	
	public function getIsClosed(): ?bool
    {
        return $this->isClosed;
    }

    public function setIsClosed(string $isClosed): self
    {
        $this->isClosed = $isClosed;

        return $this;
    }
	
	public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
	
	public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
