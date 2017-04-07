<?php
// ATrophy/Entity/Repository/MetadataRepository.php
namespace ATrophy\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class MetadataRepository extends EntityRepository
{
    public function find($id)
    {
        $query = $this->createQueryBuilder('metadata')
            ->select('metadata')
            ->where('metadata.id = :id')
            ->setParameter(':id', $id)
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getSingleResult();
    }

    public function findAll()
    {
        $query = $this->createQueryBuilder('metadata')
            ->select('metadata')
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }

    public function findByRoute($route)
    {
        $query = $this->createQueryBuilder('metadata')
            ->select('metadata')
            ->where('metadata.route = :route')
            ->setParameter(':route', $route)
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getSingleResult();
    }
}