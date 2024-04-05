<?php
namespace App\Entity;

class UserEntity
{
    public function getUsers()
    {
        $names = ["1" => "John1", "2" => "Bob", "3" => "Dennis"];
        return $names;
    }
    public function getUser(string $id): string
    {
        $names = ["1" => "John1", "2" => "Bob", "3" => "Dennis"];
        return $names[$id];
    }
}