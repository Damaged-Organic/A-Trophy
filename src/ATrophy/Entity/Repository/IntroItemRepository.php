<?php
// ATrophy/Entity/Repository/IntroItemRepository.php
namespace ATrophy\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class IntroItemRepository extends EntityRepository
{
    public function findAll()
    {
        $query = $this->createQueryBuilder('introItem')
            ->select('introItem')
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }
}