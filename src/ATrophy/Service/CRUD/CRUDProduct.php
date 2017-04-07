<?php
//src/ATrophy/Service/CRUD/CRUDProduct.php
namespace ATrophy\Service\CRUD;

use Doctrine\ORM\PersistentCollection;

use ATrophy\Entity\Shop\Product,
    ATrophy\Entity\Shop\ProductAddon,
    ATrophy\Entity\Shop\ProductItem,
    ATrophy\Entity\Shop\ItemSpecification,
    ATrophy\Entity\Shop\ItemImage;

class CRUDProduct
{
    public function combineProduct(array $product)
    {
        $product = array_merge([
            'title'        => '',
            'image'        => '',
            'imageSquare'  => '',
            'imageThumb'   => '',
            'ratingVotes'  => NULL,
            'ratingScore'  => NULL,
            'views'        => NULL,
            'currentPrice' => NULL,
            'isVisible'    => FALSE,
            'kitPrice'     => NULL,
            'thematic'     => NULL,
            'category'     => NULL,
            'subCategory'  => NULL
        ], $product);

        $product['kitPrice']  = ( $product['kitPrice'] ) ? $product['kitPrice'] : NULL;
        $product['isVisible'] = ( $product['isVisible'] ) ? TRUE : FALSE;

        return $product;
    }

    public function combineProductAddon(array $productAddon)
    {
        $productAddon = array_merge([
            'hasStatuette' => FALSE,
            'hasTopToken'  => FALSE,
            'hasRibbon'    => FALSE,
            'hasToken'     => FALSE,
            'hasPlate'     => FALSE,
            'hasBox'       => FALSE,
            'hasEtching'   => FALSE
        ], $productAddon);

        $productAddon = array_map(
            function($item) { return ( !empty($item) ) ? TRUE : FALSE; },
            $productAddon
        );

        return $productAddon;
    }

    public function combineProductItem(array $productItem)
    {
        $productItem = array_merge([
            'article'    => '',
            'price'      => NULL,
            'pricePromo' => NULL,
            'stock'      => FALSE
        ], $productItem);

        $productItem['price']      = ( $productItem['price'] ) ? $productItem['price'] : NULL;
        $productItem['pricePromo'] = ( $productItem['pricePromo'] ) ? $productItem['pricePromo'] : NULL;
        $productItem['stock']      = ( $productItem['stock'] ) ? TRUE : FALSE;

        return $productItem;
    }

    public function combineItemImage(array $itemImage)
    {
        return array_merge([
            'image'       => '',
            'imageSquare' => '',
            'imageThumb'  => ''
        ], $itemImage);
    }

    public function combineItemSpecification(array $itemSpecification)
    {
        $itemSpecification = array_map(
            function($item) { return ( !empty($item) ) ? $item : NULL; },
            $itemSpecification
        );

        return array_merge([
            'color'          => NULL,
            'colorTouch'     => NULL,
            'height'         => NULL,
            'diameterGoblet' => NULL,
            'diameterMedal'  => NULL,
            'diameterToken'  => NULL,
            'stand'          => NULL,
            'holder'         => NULL
        ], $itemSpecification);
    }

    public function setProduct(Product $product = NULL, $data, $category, $subCategory, $thematic)
    {
        $product = ( $product ) ? $product : new Product;

        $product->setTitle($data['title'])
            ->setImage($data['image'])
            ->setImageSquare($data['imageSquare'])
            ->setImageThumb($data['imageThumb'])
            ->setRatingVotes($data['ratingVotes'])
            ->setRatingScore($data['ratingScore'])
            ->setViews($data['views'])
            ->setCurrentPrice($data['currentPrice'])
            ->setIsVisible($data['isVisible'])
            ->setKitPrice($data['kitPrice'])
            ->setCategory($category)
            ->setSubcategory($subCategory)
            ->setThematic($thematic);

        return $product;
    }

    public function setProductImages(Product $product, $imagesName)
    {
        $product->setImage($imagesName['image'])
            ->setImageSquare($imagesName['imageSquare'])
            ->setImageThumb($imagesName['imageThumb']);

        return $product;
    }

    public function setProductAddon(ProductAddon $productAddon = NULL, $data, $product)
    {
        $productAddon = ( $productAddon ) ? $productAddon : new ProductAddon;

        $productAddon->setProduct($product)
            ->setHasStatuette($data['hasStatuette'])
            ->setHasTopToken($data['hasTopToken'])
            ->setHasRibbon($data['hasRibbon'])
            ->setHasToken($data['hasToken'])
            ->setHasPlate($data['hasPlate'])
            ->setHasBox($data['hasBox'])
            ->setHasEtching($data['hasEtching']);

        $product->setProductAddon($productAddon);

        return $product;
    }

    public function setProductItem(PersistentCollection $productItem, $data, $product)
    {
       foreach($data as $id => $item)
        {
            $requiredProductItem = NULL;

            foreach($productItem as $collectionItem)
            {
                if( $collectionItem->getId() == $id ) {
                    $requiredProductItem = $collectionItem;
                }
            }

            if( $requiredProductItem )
            {
                $requiredProductItem->setArticle($data[$id]['article'])
                    ->setPrice($data[$id]['price'])
                    ->setPricePromo($data[$id]['pricePromo'])
                    ->setStock($data[$id]['stock']);

                $product->addProductItem($requiredProductItem);
            }
        }

        return $product;
    }

    public function setItemImage($product, $itemImagesName)
    {
        foreach($itemImagesName as $id => $image)
        {
            $requiredProductItem = NULL;

            foreach($product->getProductItem() as $collectionItem)
            {
                if( $collectionItem->getId() == $id ) {
                    $requiredProductItem = $collectionItem;
                }
            }

            if( $requiredProductItem )
            {
                $itemImage = $requiredProductItem->getItemImage()[0];

                $itemImage->setImage($image['image'])
                    ->setImageSquare($image['imageSquare'])
                    ->setImageThumb($image['imageThumb']);

                $requiredProductItem->addItemImage($itemImage);

                $product->addProductItem($requiredProductItem);
            }
        }

        return $product;
    }

    public function setItemSpecification(PersistentCollection $productItem, $data, $product)
    {
        foreach($data as $id => $item)
        {
            $requiredProductItem = NULL;

            foreach($productItem as $collectionItem)
            {
                if( $collectionItem->getId() == $id ) {
                    $requiredProductItem = $collectionItem;
                }
            }

            if( $requiredProductItem )
            {
                $requiredItemSpecification = $requiredProductItem->getItemSpecification();

                $requiredItemSpecification->setColor($data[$id]['color'])
                    ->setColorTouch($data[$id]['colorTouch'])
                    ->setHeight($data[$id]['height'])
                    ->setDiameterGoblet($data[$id]['diameterGoblet'])
                    ->setDiameterMedal($data[$id]['diameterMedal'])
                    ->setDiameterToken($data[$id]['diameterToken'])
                    ->setStand($data[$id]['stand'])
                    ->setHolder($data[$id]['holder']);

                $requiredProductItem->setItemSpecification($requiredItemSpecification);

                $product->addProductItem($requiredProductItem);
            }
        }

        return $product;
    }

    public function addProductItem($product, $data)
    {
        $productItem = (new ProductItem)
            ->setProduct($product)
            ->setArticle($data['productItem']['article'])
            ->setPrice($data['productItem']['price'])
            ->setPricePromo($data['productItem']['pricePromo'])
            ->setStock(TRUE);

        $itemSpecification = (new ItemSpecification)
            ->setProductItem($productItem)
            ->setColor($data['itemSpecification']['color'])
            ->setColorTouch($data['itemSpecification']['colorTouch'])
            ->setHeight($data['itemSpecification']['height'])
            ->setDiameterGoblet($data['itemSpecification']['diameterGoblet'])
            ->setDiameterMedal($data['itemSpecification']['diameterMedal'])
            ->setDiameterToken($data['itemSpecification']['diameterToken'])
            ->setStand($data['itemSpecification']['stand'])
            ->setHolder($data['itemSpecification']['holder']);

        $productItem->setItemSpecification($itemSpecification);

        $itemImage = (new ItemImage)
            ->setProductItem($productItem)
            ->setImage($data['itemImage']['image'])
            ->setImageSquare($data['itemImage']['imageSquare'])
            ->setImageThumb($data['itemImage']['imageThumb']);

        $productItem->addItemImage($itemImage);

        $product->addProductItem($productItem);

        return $product;
    }
}