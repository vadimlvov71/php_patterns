<?php
namespace App\Entity;

class IndexEntity
{
    public function getName(string $id): string
    {
        $names = ["1" => "John1", "2" => "Bob", "3" => "Dennis"];
        return $names[$id];
    }
}