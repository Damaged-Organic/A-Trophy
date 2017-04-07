<?php
// src/ATrophy/Entity/Repository/Shop/TokenRepository.php
namespace ATrophy\Entity\Repository\Shop;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\Query;

class TokenRepository extends EntityRepository
{
    public function find($id)
    {
        $query = $this->createQueryBuilder('token')
            ->select('token')
            ->where('token.id = :id')
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
        $query = $this->createQueryBuilder('token')
            ->select('token')
            ->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }

    public function findByDiameter($diameter)
    {
        $query = $this->createQueryBuilder('token')
            ->select('token')
            ->where('token.diameter = :diameter')
            ->setParameter('diameter', $diameter)
            ->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }
}