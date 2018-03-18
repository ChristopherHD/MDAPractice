<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10)
     */

    private $dni;

    /**
     * @ORM\Column(type="string", length=25)
     */

    private $social_security_number;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $phone;

    /**
     * @ORM\Column(type="date")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $password;

    /**
     * @ORM\Column(name="isDoctor", type="boolean", nullable=true)
     */
    private $isDoctor;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $medical_history;

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIsDoctor(): ?bool
    {
        return $this->isDoctor;
    }

    public function setIsDoctor(?bool $isDoctor): self
    {
        $this->isDoctor = $isDoctor;

        return $this;
    }

    public function getMedicalHistory(): ?string
    {
        return $this->medical_history;
    }

    public function setMedicalHistory(?string $medical_history): self
    {
        $this->medical_history = $medical_history;

        return $this;
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
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return mixed
     */
    public function getSocialSecurityNumber()
    {
        return $this->social_security_number;
    }

    /**
     * @param mixed $social_security_number
     */
    public function setSocialSecurityNumber($social_security_number)
    {
        $this->social_security_number = $social_security_number;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @param mixed $dni
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    }
}

