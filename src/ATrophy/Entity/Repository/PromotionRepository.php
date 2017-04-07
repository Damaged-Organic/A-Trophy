<?php
// src/ATrophy/Entity/Repository/PromotionRepository.php
namespace ATrophy\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class PromotionRepository extends EntityRepository
{
    public function findOrderedPromotions()
    {
        $query = $this->createQueryBuilder('promotion')
            ->select('promotion')
            ->orderBy('promotion.created', 'DESC')
            ->getQuery();

        return $query->getResult();
    }
}