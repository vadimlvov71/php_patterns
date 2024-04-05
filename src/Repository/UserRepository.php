<?php
namespace App\Repository;

use App\Entity\UserEntity;

class UserRepository
{
    public function __construct(
        private UserEntity $userEntity
     )
     {}
    public function getName(string $id)
    {
        $name = $this->userEntity->getName($id);
        return $name;
    }
    public function getUsers()
    {
        $name = $this->userEntity->getUsers();
        return $name;
    }
}