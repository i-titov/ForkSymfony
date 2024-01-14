<?php
namespace App\Entity;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class UserConnection{
    protected string $userName;
    protected string $password;
    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}