<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users implements UserInterface
{

    public function __construct($username=null, $password=null, $dni=null, $social_security_number=null, $birthdate=null, $phone=null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->dni = $dni;
        $this->social_security_number = $social_security_number;
        $this->birthdate = $birthdate;
        $this->phone = $phone;

    }
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=45)
     */
    private $username;

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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $name): self
    {
        $this->username = $name;

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

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        if($this->isDoctor === True) return array('ROLE_DOC');
        return array('ROLE_USER');

    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}

