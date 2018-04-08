<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\AppointmentsRepository")
 */
class Appointments
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var integer $patient
	 * @ORM\ManyToOne(targetEntity="Users")
	 * @ORM\JoinColumn(name="patient", referencedColumnName="id")
     */
    private $patient;

    /**
     * @var integer $doctor
	 * @ORM\ManyToOne(targetEntity="Users")
	 * @ORM\JoinColumn(name="doctor", referencedColumnName="id")
     */
    private $doctor;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

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
}
