<?php
// ATrophy/Entity/Repository/PaymentRepository.php
namespace ATrophy\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class PaymentRepository extends EntityRepository
{
    public function findAll()
    {
        $query = $this->createQueryBuilder('payment')
            ->select('payment')
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }
}