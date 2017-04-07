<?php
// src/ATrophy/Entity/Repository/Order/OrderRepository.php
namespace ATrophy\Entity\Repository\Order;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\Query;

class OrderRepository extends EntityRepository
{
    public function findOrderIds()
    {
        $query = $this->createQueryBuilder('order')
            ->select('partial order.{id,orderId}')
            ->getQuery();

        return $query->getResult(Query::HYDRATE_ARRAY);
    }
}