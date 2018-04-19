<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
        $this->creditCard = null;
        $this->isSubscribed = false;

    }
    /**
     * @ORM\Id()
     * @ORM\Column(type="string",length=10)
     */
    private $dni;

    /**
     * @ORM\Column(name="name", type="string", length=45)
     */
    private $username;

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
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $medical_history;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isSubscribed;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $creditCard;

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
        return null;
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

    /**
     * @return mixed
     */
    public function getDni()
    {
        return $this->dni;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->dni;
    }

    /**
     * @param mixed $dni
     */
    public function setDni($dni): void
    {
        $this->dni = $dni;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return mixed
     */
    public function getIsSubscribed()
    {
        if(!isset($this->isSubscribed)) return false;
        return $this->isSubscribed;
    }

    /**
     * @param mixed $isSubscribed
     */
    public function setIsSubscribed($isSubscribed): void
    {
        $this->isSubscribed = $isSubscribed;
    }

    /**
     * @return mixed
     */
    public function getCreditCard()
    {
        return $this->creditCard;
    }

    /**
     * @param mixed $creditCard
     */
    public function setCreditCard($creditCard): void
    {
        $this->creditCard = $creditCard;
    }
}

