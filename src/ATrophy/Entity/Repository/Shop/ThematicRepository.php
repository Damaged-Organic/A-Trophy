<?php
// ATrophy/Entity/Repository/Shop/ThematicRepository.php
namespace ATrophy\Entity\Repository\Shop;

use Doctrine\ORM\EntityRepository;

class ThematicRepository extends EntityRepository
{
    public function find($id)
    {
        $query = $this->createQueryBuilder('thematic')
            ->select('thematic')
            ->where('thematic.id = :id')
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getSingleResult();
    }

    public function findAllAlphabetOrdered()
    {
        $query = $this->createQueryBuilder('thematic')
            ->select('thematic')
            ->orderBy('thematic.title', 'ASC')
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }

    public function findDefaultThematic()
    {
        $query = $this->createQueryBuilder('thematic')
            ->select('thematic')
            ->where('thematic.title = :title OR thematic.id = :id')
            ->setParameters(['title' => "Нейтральные", 'id' => 1])
            ->orderBy('thematic.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getSingleResult();
    }
}