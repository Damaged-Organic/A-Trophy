<?php
// ATrophy/Entity/Repository/Shop/ProductItemRepository.php
namespace ATrophy\Entity\Repository\Shop;

use Doctrine\ORM\EntityRepository;

class ProductItemRepository extends EntityRepository
{
    public function findMaxPrice()
    {
        $result = $this->createQueryBuilder('productItem')
            ->select('MAX(productItem.price) AS maxPrice')
            ->getQuery()
            ->getSingleResult();

        return $result['maxPrice'];
    }

    public function findMinPriceByProduct($productId)
    {
        $result = $this->createQueryBuilder('productItem')
            ->select('MIN(productItem.price) AS minPrice, MIN(productItem.pricePromo) AS minPricePromo')
            ->where('productItem.price IS NOT NULL OR productItem.pricePromo IS NOT NULL')
            ->andWhere('productItem.product = :productId')
            ->setParameter('productId', $productId)
            ->getQuery()
            ->getSingleResult();

        return min([
            ( !is_null($result['minPrice']) ) ? $result['minPrice'] : PHP_INT_MAX,
            ( !is_null($result['minPricePromo']) ) ? $result['minPricePromo'] : PHP_INT_MAX
        ]);
    }

    public function findAnyProductItem($id)
    {
        $result = $this->createQueryBuilder('productItem')
            ->select('productItem')
            ->where('productItem.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $result->getSingleResult();
    }
}