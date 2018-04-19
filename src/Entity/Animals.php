<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @property \DateTimeInterface datetime
 * @ORM\Entity(repositoryClass="App\Repository\AnimalsRepository")
 */
class Animals
{

    public function __construct($date=null, $name=null, $type=false,$birthdate=null,$other=null,$owner=null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->birthdate = $birthdate;
		$this->owner=$owner;
		$this->other = $other;
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
    private $owner;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthdate;
	
    /**
     * @ORM\Column(type="string", length=200 )
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=200, nullable=true )
     */
    private $other;

    /**
     * @ORM\Column(type="string", length=200 )
     */
    private $name;


    public function getId()
    {
        return $this->id;
    }


    public function getOwner(): ?Users
    {
        return $this->owner;
    }


    public function setOwner(Users $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate): void
    {
        $this->birthdate = $birthdate;
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

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getOther()
    {
        return $this->other;
    }

    /**
     * @param mixed $other
     */
    public function setOther($other): void
    {
        $this->other = $other;
    }


}
