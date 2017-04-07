<?php
// src/ATrophy/Entity/Repository/Shop/RibbonRepository.php
namespace ATrophy\Entity\Repository\Shop;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\Query;

class RibbonRepository extends EntityRepository
{
    public function find($id)
    {
        $query = $this->createQueryBuilder('ribbon')
            ->select('ribbon')
            ->where('ribbon.id = :id')
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
        $query = $this->createQueryBuilder('ribbon')
            ->select('ribbon')
            ->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }

    public function findByWidth($width)
    {
        $query = $this->createQueryBuilder('ribbon')
            ->select('ribbon')
            ->where('ribbon.width = :width')
            ->setParameter('width', $width)
            ->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }
}