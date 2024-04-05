<?php
namespace App\Repository;

use App\Entity\IndexEntity;

class IndexRepository
{
    public function __construct(
        private IndexEntity $indexEntity
     )
     {}
    public function getName(string $id)
    {
        $name = $this->indexEntity->getName($id);
        return $name;
    }
    
}