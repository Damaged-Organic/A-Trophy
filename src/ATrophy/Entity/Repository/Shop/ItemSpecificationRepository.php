<?php
// ATrophy/Entity/Repository/Shop/ItemSpecificationRepository.php
namespace ATrophy\Entity\Repository\Shop;

use Doctrine\ORM\EntityRepository;

class ItemSpecificationRepository extends EntityRepository
{
    public function findSpecificationsByCategory($category_parameter)
    {
        $query = $this->createQueryBuilder('itemSpecification')
            ->select('itemSpecification, productItem, productAddon, product, category')
            ->leftJoin('itemSpecification.productItem', 'productItem')
            ->leftJoin('productItem.product', 'product')
            ->leftJoin('product.category', 'category')
            ->leftJoin('product.productAddon', 'productAddon')
            ->where('category.parameter = :parameter')
            ->setParameter('parameter', $category_parameter);

        $query = $query->getQuery();

        // $query->setHint(
        //     \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
        //     'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        // );

        return $query->getResult();
    }
}
