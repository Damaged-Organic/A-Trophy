<?php
// src/ATrophy/Entity/Repository/Shop/BoxRepository.php
namespace ATrophy\Entity\Repository\Shop;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\Query;

class BoxRepository extends EntityRepository
{
    public function find($id)
    {
        $query = $this->createQueryBuilder('box')
            ->select('box')
            ->where('box.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getSingleResult();
    }

    public function findAll()
    {
        $query = $this->createQueryBuilder('box')
            ->select('box')
            ->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }

    public function findFitBySize($minSize, $maxSize)
    {
        $query = $this->createQueryBuilder('box')
            ->select('box')
            ->where('box.size > :minSize')
            ->andWhere('box.size <= :maxSize')
            ->setParameter('minSize', $minSize)
            ->setParameter('maxSize', $maxSize)
            ->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }
}