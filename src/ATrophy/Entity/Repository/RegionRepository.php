<?php
// src/ATrophy/Entity/Repository/RegionRepository.php
namespace ATrophy\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class RegionRepository extends EntityRepository
{
    public function findAllOrdered()
    {
        $query = $this->createQueryBuilder('region')
            ->select('region')
            ->orderBy('region.title', 'ASC')
            ->getQuery();

        return $query->getResult();
    }
}