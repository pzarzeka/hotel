<?php

namespace App\Services;

use App\User;

class LoginService
{
    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    public function __construct($user, $password)
    {
        $this->setUser($user);
        $this->setPassword($password);
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function login()
    {
        $user = User::where('name', $this->getUser())
            ->where('password', md5($this->getPassword()))
            ->first();

        if ($user === null) {
            return false;
        }

        return true;
    }

}