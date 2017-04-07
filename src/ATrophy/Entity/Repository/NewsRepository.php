<?php
// ATrophy/Entity/Repository/NewsRepository.php
namespace ATrophy\Entity\Repository;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\Tools\Pagination\Paginator;

class NewsRepository extends EntityRepository
{
    public function find($id)
    {
        $query = $this->createQueryBuilder('news')
            ->select('news')
            ->where('news.id = :id')
            ->setParameter(':id', $id)
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }

    public function findLimitedRecent($page, $results_per_page)
    {
        $first_record = ($page * $results_per_page) - $results_per_page;

        $query = $this->createQueryBuilder('news')
            ->select('news')
            ->orderBy('news.created', 'DESC')
            ->setFirstResult($first_record)
            ->setMaxResults($results_per_page)
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return new Paginator($query);
    }
}