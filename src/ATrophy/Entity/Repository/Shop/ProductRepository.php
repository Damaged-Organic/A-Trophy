<?php
// ATrophy/Entity/Repository/Shop/ProductRepository.php
namespace ATrophy\Entity\Repository\Shop;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\Tools\Pagination\Paginator;

class ProductRepository extends EntityRepository
{
    public function findNeatProduct($id)
    {
        $query = $this->createQueryBuilder('product')
            ->select('product')
            ->where('product.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getSingleResult();
    }

    public function findProduct($id, $roleAdmin)
    {
        $query = $this->createQueryBuilder('product')
            ->select('product, category, subcategory, thematic, productAddon, productItem, itemSpecification, itemImage')
            ->leftJoin('product.category', 'category')
            ->leftJoin('product.subcategory', 'subcategory')
            ->leftJoin('product.thematic', 'thematic')
            ->leftJoin('product.productAddon', 'productAddon')
            ->leftJoin('product.productItem', 'productItem')
            ->leftJoin('productItem.itemSpecification', 'itemSpecification')
            ->leftJoin('productItem.itemImage', 'itemImage');

        #ADMIN!
        if( !$roleAdmin )
        {
            $query->where('productItem.id IS NOT NULL')
                ->andWhere('productItem.article IS NOT NULL')
                ->andWhere('productItem.article <> :empty')
                ->setParameter('empty', '')
                ->andWhere('productItem.price IS NOT NULL OR productItem.pricePromo IS NOT NULL')
                ->andWhere('product.isVisible = :isVisible')
                ->setParameter('isVisible', TRUE);
        }

        $query->andWhere('product.id = :id')
            ->setParameter('id', $id);

        $query = $query->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }

    public function findAny($id)
    {
        $query = $this->createQueryBuilder('product')
            ->select('product, category, subcategory, thematic, productAddon, productItem, itemSpecification, itemImage')
            ->leftJoin('product.category', 'category')
            ->leftJoin('product.subcategory', 'subcategory')
            ->leftJoin('product.thematic', 'thematic')
            ->leftJoin('product.productAddon', 'productAddon')
            ->leftJoin('product.productItem', 'productItem')
            ->leftJoin('productItem.itemSpecification', 'itemSpecification')
            ->leftJoin('productItem.itemImage', 'itemImage')
            ->andWhere('product.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getSingleResult();
    }

    public function findProducts($category_parameter = NULL, $thematic_parameter = NULL, $filter_parameters = NULL, $sorting_parameter = NULL, array $pagination = NULL, $roleAdmin)
    {
        $qb = $this->createQueryBuilder('product');

        $query = $qb->select('product, category, subcategory, thematic, productItem, productAddon, itemSpecification')
            ->leftJoin('product.category', 'category')
            ->leftJoin('product.subcategory', 'subcategory')
            ->leftJoin('product.thematic', 'thematic')
            ->leftJoin('product.productItem', 'productItem')
            ->leftJoin('product.productAddon', 'productAddon')
            ->leftJoin('productItem.itemSpecification', 'itemSpecification');

        #ADMIN!
        if( !$roleAdmin )
        {
            $query->where('productItem.id IS NOT NULL')
                ->andWhere('productItem.article IS NOT NULL')
                ->andWhere('productItem.article <> :empty')
                ->setParameter('empty', '')
                ->andWhere('productItem.price IS NOT NULL OR productItem.pricePromo IS NOT NULL')
                ->andWhere('product.isVisible = :isVisible')
                ->setParameter('isVisible', TRUE);
        }

        #category condition
        if( !empty($category_parameter) )
        {
            $query->andWhere('category.parameter = :parameter')
                ->setParameter('parameter', $category_parameter);
        }

        #thematic condition
        if( !empty($thematic_parameter) )
        {
            $query->andWhere('thematic.id = :id')
                ->setParameter('id', $thematic_parameter);
        }

        #filter conditions
        if( !empty($filter_parameters) )
        {
            /* Subcategory filter */

            if( !empty($filter_parameters['subcategory']) )
            {
                $orx = $qb->expr()->orX();

                foreach($filter_parameters['subcategory'] as $key => $value) {
                    $orx->add($qb->expr()->eq('subcategory.id', ":subcategory_{$key}"));
                }

                $query->andWhere($orx);

                foreach($filter_parameters['subcategory'] as $key => $value) {
                    $query->setParameter("subcategory_{$key}", $value);
                }
            }

            /* Specifications filters */

            if( !empty($filter_parameters['color']) )
            {
                $orx = $qb->expr()->orX();

                foreach($filter_parameters['color'] as $key => $value) {
                    $orx->add($qb->expr()->eq('itemSpecification.color', ":color_{$key}"));
                }

                $query->andWhere($orx);

                foreach($filter_parameters['color'] as $key => $value) {
                    $query->setParameter("color_{$key}", $value);
                }
            }

            if( !empty($filter_parameters['colorTouch']) )
            {
                $orx = $qb->expr()->orX();

                foreach($filter_parameters['colorTouch'] as $key => $value) {
                    $orx->add($qb->expr()->eq('itemSpecification.colorTouch', ":colorTouch_{$key}"));
                }

                $query->andWhere($orx);

                foreach($filter_parameters['colorTouch'] as $key => $value) {
                    $query->setParameter("colorTouch_{$key}", $value);
                }
            }

            if( !empty($filter_parameters['height']) )
            {
                $orx = $qb->expr()->orX();

                foreach($filter_parameters['height'] as $key => $value) {
                    $orx->add($qb->expr()->eq('itemSpecification.height', ":height_{$key}"));
                }

                $query->andWhere($orx);

                foreach($filter_parameters['height'] as $key => $value) {
                    $query->setParameter("height_{$key}", $value);
                }
            }

            if( !empty($filter_parameters['diameterGoblet']) )
            {
                $orx = $qb->expr()->orX();

                foreach($filter_parameters['diameterGoblet'] as $key => $value) {
                    $orx->add($qb->expr()->eq('itemSpecification.diameterGoblet', ":diameterGoblet_{$key}"));
                }

                $query->andWhere($orx);

                foreach($filter_parameters['diameterGoblet'] as $key => $value) {
                    $query->setParameter("diameterGoblet_{$key}", $value);
                }
            }

            if( !empty($filter_parameters['diameterMedal']) )
            {
                $orx = $qb->expr()->orX();

                foreach($filter_parameters['diameterMedal'] as $key => $value) {
                    $orx->add($qb->expr()->eq('itemSpecification.diameterMedal', ":diameterMedal_{$key}"));
                }

                $query->andWhere($orx);

                foreach($filter_parameters['diameterMedal'] as $key => $value) {
                    $query->setParameter("diameterMedal_{$key}", $value);
                }
            }

            /* Common filters */

            if ( !empty($filter_parameters['is_stock']) ) {
                $query->andWhere('productItem.stock = :stock')
                    ->setParameter('stock', TRUE);
            }

            if ( !empty($filter_parameters['is_promo']) ) {
                $query->andWhere('productItem.pricePromo <> :pricePromo')
                    ->setParameter('pricePromo', 'NULL');
            }

            if( isset($filter_parameters['min_price']) && isset($filter_parameters['max_price']) )
            {
                $query->andWhere('productItem.price >= :min_price OR productItem.pricePromo >= :min_price_promo')
                    ->andWhere('productItem.price <= :max_price OR productItem.pricePromo <= :max_price_promo')
                    ->setParameter('min_price', $filter_parameters['min_price'])
                    ->setParameter('min_price_promo', $filter_parameters['min_price'])
                    ->setParameter('max_price', $filter_parameters['max_price'])
                    ->setParameter('max_price_promo', $filter_parameters['max_price']);
            }
        }

        #sorting condition
        if( !empty($sorting_parameter) )
        {
            switch($sorting_parameter)
            {
                case 'alphabetAsc':
                    $sorting = ['field' => 'product.title', 'order' => 'ASC'];
                break;

                case 'alphabetDesc':
                    $sorting = ['field' => 'product.title', 'order' => 'DESC'];
                break;

                case 'priceAsc':
                    $sorting = ['field' => 'product.currentPrice', 'order' => 'ASC'];
                break;

                case 'priceDesc':
                    $sorting = ['field' => 'product.currentPrice', 'order' => 'DESC'];
                break;

                case 'ratingAsc':
                    $sorting = ['field' => 'product.ratingScore', 'order' => 'DESC'];
                break;

                case 'ratingDesc':
                    $sorting = ['field' => 'product.ratingScore', 'order' => 'ASC'];
                break;

                case 'newestAsc':
                    $sorting = ['field' => 'product.updated', 'order' => 'ASC'];
                break;

                case 'newestDesc':
                    $sorting = ['field' => 'product.updated', 'order' => 'DESC'];
                break;
            }

            if( !empty($sorting) ) {
                $query->orderBy($sorting['field'], $sorting['order']);
            }
        } else {
            $query->orderBy('product.ratingScore', 'DESC');
        }

        if( !empty($pagination['current_page']) && !empty($pagination['records_per_page']) )
        {
            $first_record = ($pagination['current_page'] * $pagination['records_per_page']) - $pagination['records_per_page'];

            $query->setFirstResult($first_record)
                ->setMaxResults($pagination['records_per_page']);
        }

        $query = $query->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return new Paginator($query);
    }

    public function findProductsByIds(array $ids, $roleAdmin)
    {
        $query = $this->createQueryBuilder('product')
            ->select('product, productItem, itemSpecification, itemImage')
            ->leftJoin('product.productItem', 'productItem')
            ->leftJoin('productItem.itemSpecification', 'itemSpecification')
            ->leftJoin('productItem.itemImage', 'itemImage');

        #ADMIN!
        if( !$roleAdmin )
        {
            $query->where('productItem.id IS NOT NULL')
                ->andWhere('productItem.article IS NOT NULL')
                ->andWhere('productItem.article <> :empty')
                ->setParameter('empty', '')
                ->andWhere('productItem.price IS NOT NULL OR productItem.pricePromo IS NOT NULL')
                ->andWhere('product.isVisible = :isVisible')
                ->setParameter('isVisible', TRUE);
        }

        $query->andWhere('product.id IN (:ids)')
            ->setParameter('ids', $ids);

        $query = $query->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function findStatuettes($roleAdmin)
    {
        $query = $this->createQueryBuilder('product')
            ->select('product, subcategory, productItem, itemSpecification, itemImage')
            ->leftJoin('product.subcategory', 'subcategory')
            ->leftJoin('product.productItem', 'productItem')
            ->leftJoin('productItem.itemSpecification', 'itemSpecification')
            ->leftJoin('productItem.itemImage', 'itemImage');

        #ADMIN!
        if( !$roleAdmin )
        {
            $query->where('productItem.id IS NOT NULL')
                ->andWhere('productItem.article IS NOT NULL')
                ->andWhere('productItem.article <> :empty')
                ->setParameter('empty', '')
                ->andWhere('productItem.price IS NOT NULL OR productItem.pricePromo IS NOT NULL')
                ->andWhere('product.isVisible = :isVisible')
                ->setParameter('isVisible', TRUE);
        }

        $query->andWhere('product.subcategory = :subcategory')
            ->setParameter('subcategory', 10);

        $query = $query->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }

    public function findStatuette($id, $roleAdmin)
    {
        $query = $this->createQueryBuilder('product')
            ->select('product, subcategory, productItem, itemSpecification, itemImage')
            ->leftJoin('product.subcategory', 'subcategory')
            ->leftJoin('product.productItem', 'productItem')
            ->leftJoin('productItem.itemSpecification', 'itemSpecification')
            ->leftJoin('productItem.itemImage', 'itemImage');

        #ADMIN!
        if( !$roleAdmin )
        {
            $query->where('productItem.id IS NOT NULL')
                ->andWhere('productItem.article IS NOT NULL')
                ->andWhere('productItem.article <> :empty')
                ->setParameter('empty', '')
                ->andWhere('productItem.price IS NOT NULL OR productItem.pricePromo IS NOT NULL')
                ->andWhere('product.isVisible = :isVisible')
                ->setParameter('isVisible', TRUE);
        }

        $query->andWhere('product.subcategory = :subcategory')
            ->setParameter('subcategory', 10)
            ->andWhere('productItem.id = :id')
            ->setParameter('id', $id);

        $query = $query->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }

    public function findBySearchString($searchString, $pagination, $roleAdmin)
    {
        $query = $this->createQueryBuilder('product')
            ->select('product, productItem')
            ->leftJoin('product.productItem', 'productItem');

        #ADMIN!
        if( !$roleAdmin )
        {
            $query->where('productItem.id IS NOT NULL')
                ->andWhere('productItem.article IS NOT NULL')
                ->andWhere('productItem.article <> ?1')
                ->setParameter('1', '')
                ->andWhere('productItem.price IS NOT NULL OR productItem.pricePromo IS NOT NULL')
                ->andWhere('product.isVisible = ?2')
                ->setParameter('2', TRUE);
        }

        $query->andWhere('product.title LIKE ?3 OR productItem.article LIKE ?4')
            ->setParameter('3', "%{$searchString}%")
            ->setParameter('4', "%{$searchString}%");

        if( !empty($pagination['current_page']) && !empty($pagination['records_per_page']) )
        {
            $first_record = ($pagination['current_page'] * $pagination['records_per_page']) - $pagination['records_per_page'];

            $query->setFirstResult($first_record)
                ->setMaxResults($pagination['records_per_page']);
        }

        $query = $query->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return new Paginator($query);
    }
}
