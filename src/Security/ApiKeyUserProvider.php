<?php

// src/Security/ApiKeyUserProvider.php
namespace App\Security;


use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;


class ApiKeyUserProvider implements UserProviderInterface
{
    private $er;

    public function __construct(UsersRepository $er)
    {
        $this->er = $er;
    }

    public function loadUserByUsername($key)
    {
        // make a call to your webservice here
        $userData = $this->er->findByApiKey($key);
        // pretend it returns an array on success, false if there is no user
        if($userData) return $userData;

        throw new ParameterNotFoundException(
            sprintf('Api Key "%s" does not exist.', $key)
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof Users) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return Users::class === $class;
    }
}