<?php
// src/ATrophy/Entity/Repository/Shop/CategoryRepository.php:2
namespace ATrophy\Entity\Repository\Shop;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\Tools\Pagination\Paginator;

class CategoryRepository extends EntityRepository
{
    public function findbyLevel($level)
    {
        $query = $this->createQueryBuilder('category')
            ->select('category')
            ->where('category.level = :level')
            ->setParameter('level', $level)
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }

    public function findByParameter($parameter)
    {
        $query = $this->createQueryBuilder('category')
            ->select('category')
            ->where('category.parameter = :parameter')
            ->setParameter('parameter', $parameter)
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getSingleResult();
    }

    public function findSubcategoriesByCategory($category)
    {
        $query = $this->getEntityManager()->createQuery("
            SELECT
                c1
            FROM
                ATrophy\\Entity\\Shop\\Category c1
                LEFT JOIN ATrophy\\Entity\\Shop\\Category c2
                    WITH c1.level = c2.id
            WHERE
                c2.parameter = :parameter
        ");

        $query->setParameter('parameter', $category);

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }

    //DEM

    public function findAllCategories()
    {
        $query = $this->createQueryBuilder('category')
            ->select('category')
            ->where('category.level = :level')
            ->setParameter('level', 0)
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }

    public function findAllSubCategories()
    {
        $query = $this->createQueryBuilder('category')
            ->select('category')
            ->where('category.level <> :level')
            ->setParameter('level', 0)
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }
}
