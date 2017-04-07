<?php
// ATrophy/Entity/Repository/ClientRepository.php
namespace ATrophy\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ClientRepository extends EntityRepository
{
    public function findAll()
    {
        $query = $this->createQueryBuilder('client')
            ->select('client')
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }
}