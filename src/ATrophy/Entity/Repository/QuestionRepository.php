<?php
// ATrophy/Entity/Repository/QuestionRepository.php
namespace ATrophy\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class QuestionRepository extends EntityRepository
{
    public function find($id)
    {
        $query = $this->createQueryBuilder('question')
            ->select('question')
            ->where('question.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getSingleResult();
    }

    public function findRecent()
    {
        $query = $this->createQueryBuilder('question')
            ->select('question')
            ->orderBy('question.updated', 'DESC')
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }
}