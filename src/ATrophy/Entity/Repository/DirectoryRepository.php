<?php
// ATrophy/Entity/Repository/DirectoryRepository.php
namespace ATrophy\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class DirectoryRepository extends EntityRepository
{
    public function findAll()
    {
        $query = $this->createQueryBuilder('directory')
            ->select('directory')
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }
	
	public function findByRoute($route)
	{
		$query = $this->createQueryBuilder('directory')
            ->select('directory')
			->where('directory.route = :route')
            ->setParameter('route', $route)
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getSingleResult();
	}
}