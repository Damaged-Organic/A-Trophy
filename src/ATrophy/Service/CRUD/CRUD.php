<?php
//src/ATrophy/Service/CRUD.php
namespace ATrophy\Service\CRUD;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Doctrine\ORM\EntityManager;

use ATrophy\Service\FileUpload;

class CRUD
{
    const BUNDLE = 'ATrophy\Entity';

    private $_manager;

    private $_CRUDProduct;
    private $_CRUDAddon;
    private $_CRUDNews;
    private $_CRUDFaq;
    private $_CRUDPromotion;

    private $_fileUpload;

    public function __construct(EntityManager $_manager, CRUDProduct $CRUDProduct, CRUDAddon $CRUDAddon, CRUDNews $CRUDNews, CRUDFaq $CRUDFaq, CRUDPromotion $CRUDPromotion, FileUpload $fileUpload)
    {
        $this->_manager = $_manager;

        $this->_CRUDProduct   = $CRUDProduct;
        $this->_CRUDAddon     = $CRUDAddon;
        $this->_CRUDNews      = $CRUDNews;
        $this->_CRUDFaq       = $CRUDFaq;
        $this->_CRUDPromotion = $CRUDPromotion;

        $this->_fileUpload  = $fileUpload;
    }

    /* Products */

    public function createProduct($data, $file)
    {
        //DataCraft
        $data['product'] = ( !empty($data['product']) ) ? $data['product'] : [];
        $data['product'] = $this->_CRUDProduct->combineProduct($data['product']);

        $data['productAddon'] = ( !empty($data['productAddon']) ) ? $data['productAddon'] : [];
        $data['productAddon'] = $this->_CRUDProduct->combineProductAddon($data['productAddon']);

        $thematic    = $this->getThematic($data['product']['thematic']);
        $category    = $this->getCategory($data['product']['category']);
        $subCategory = $this->getCategory($data['product']['subCategory']);

        $product = $this->_CRUDProduct->setProduct(NULL, $data['product'], $category, $subCategory, $thematic);
        $product = $this->_CRUDProduct->setProductAddon(NULL, $data['productAddon'], $product);

        $this->_manager->persist($product);

        $this->_manager->flush();

        //FileCraft
        if( !empty($file['file']['image']) )
        {
            $imagesName = $this->_fileUpload->saveProductImage($file['file']['image'], $product->getId());

            $product = $this->_CRUDProduct->setProductImages($product, $imagesName);

            $this->_manager->persist($product);

            $this->_manager->flush();
        }

        return $product->getId();
    }

    public function updateProduct($product, $data, $file)
    {
        //DataCraft
        $data['product'] = ( !empty($data['product']) ) ? $data['product'] : [];
        $data['product'] = $this->_CRUDProduct->combineProduct($data['product']);

        $data['productAddon'] = ( !empty($data['productAddon']) ) ? $data['productAddon'] : [];
        $data['productAddon'] = $this->_CRUDProduct->combineProductAddon($data['productAddon']);

        $data['productItem'] = ( !empty($data['productItem']) ) ? $data['productItem'] : [];
        foreach($data['productItem'] as $key => $value) {
            $data['productItem'][$key] = $this->_CRUDProduct->combineProductItem($value);
        }

        $data['productSpecification'] = ( !empty($data['productSpecification']) ) ? $data['productSpecification'] : [];
        foreach($data['productSpecification'] as $key => $value) {
            $data['productSpecification'][$key] = $this->_CRUDProduct->combineItemSpecification($value);
        }

        $thematic    = $this->getThematic($data['product']['thematic']);
        $category    = $this->getCategory($data['product']['category']);
        $subCategory = $this->getCategory($data['product']['subCategory']);

        $product = $this->_CRUDProduct->setProduct($product, $data['product'], $category, $subCategory, $thematic);
        $product = $this->_CRUDProduct->setProductAddon($product->getProductAddon(), $data['productAddon'], $product);
        $product = $this->_CRUDProduct->setProductItem($product->getProductItem(), $data['productItem'], $product);
        $product = $this->_CRUDProduct->setItemSpecification($product->getProductItem(), $data['productSpecification'], $product);

        $this->_manager->persist($product);

        $this->_manager->flush();

        //FileCraft
        if( !empty($file['file']['image']) )
        {
            $imagesName = $this->_fileUpload->saveProductImage($file['file']['image'], $product->getId());

            $product = $this->_CRUDProduct->setProductImages($product, $imagesName);

            $this->_manager->persist($product);

            $this->_manager->flush();
        }

        if( !empty($file['file']['images']) )
        {
            foreach($file['file']['images'] as $itemId => $image) {
                if( $image instanceof UploadedFile ) {
                    $itemImagesName[$itemId] = $this->_fileUpload->saveProductImage($image, $product->getId(), "_item_{$itemId}");
                }
            }

            if( !empty($itemImagesName) )
            {
                $product = $this->_CRUDProduct->setItemImage($product, $itemImagesName);

                $this->_manager->persist($product);

                $this->_manager->flush();
            }
        }
    }

    public function deleteProduct($product)
    {
        $productId = $product->getId();

        $this->_manager->remove($product);

        $this->_manager->flush();

        $this->_fileUpload->removeProductImages($productId);
    }

    public function removeProductPicture($product)
    {
        $image       = $product->getImage();
        $imageSquare = $product->getImageSquare();
        $imageThumb  = $product->getImageThumb();

        $product->setImage('')
            ->setImageSquare('')
            ->setImageThumb('');

        $this->_manager->persist($product);

        $this->_manager->flush();

        $this->_fileUpload->removeProductImages($product->getId(), [$image, $imageSquare, $imageThumb]);
    }

    public function addProductItem($product)
    {
        $data['productItem']       = $this->_CRUDProduct->combineProductItem([]);
        $data['itemSpecification'] = $this->_CRUDProduct->combineItemSpecification([]);
        $data['itemImage']         = $this->_CRUDProduct->combineItemImage([]);

        $product = $this->_CRUDProduct->addProductItem($product, $data);

        $this->_manager->persist($product);

        $this->_manager->flush();
    }

    public function removeProductItem($productItem)
    {
        $productId = $productItem->getProduct()->getId();

        $itemImage = $productItem->getItemImage()[0];

        $image       = $itemImage->getImage();
        $imageSquare = $itemImage->getImageSquare();
        $imageThumb  = $itemImage->getImageThumb();

        $this->_manager->remove($productItem);

        $this->_manager->flush();

        $this->_fileUpload->removeProductImages($productId, [$image, $imageSquare, $imageThumb]);

        return $productId;
    }

    /* END\Products */

    /* Addons */

    public function addAddon($addonType)
    {
        $data = $this->_CRUDAddon->combineAddon($addonType, []);

        $addon = $this->_CRUDAddon->addAddon($addonType, $data);

        if( !$addon ) {
            return FALSE;
        }

        $this->_manager->persist($addon);

        $this->_manager->flush();
    }

    public function updateAddons($addonType, $addons, $data, $file)
    {
        //DataCraft
        $data['addons'] = ( !empty($data['addons']) ) ? $data['addons'] : [];
        foreach($data['addons'] as $key => $value){
            $data['addons'][$key] = $this->_CRUDAddon->combineAddon($addonType, $value);

            if( empty($data['addons'][$key]) )
                unset($data['addons'][$key]);
        }

        $addons = $this->_CRUDAddon->setAddons($addonType, $addons, $data['addons']);

        foreach($addons as $key => $value) {
            $this->_manager->persist($value);
        }

        $this->_manager->flush();

        //FileCraft
        if( !empty($file['file']['image']) )
        {
            foreach($file['file']['image'] as $addonId => $image) {
                if( $image instanceof UploadedFile ) {
                    $addonImagesName[$addonId] = $this->_fileUpload->saveAddonImage($image, $addonType, $addonId);
                }
            }

            if( !empty($addonImagesName) )
            {
                foreach($addons as $key => $addon)
                {
                    if( isset($addonImagesName[$addon->getId()]) ) {
                        $addon = $this->_CRUDAddon->setAddonImage($addon, $addonImagesName[$addon->getId()]['image']);

                        $this->_manager->persist($addon);
                    }

                }

                $this->_manager->flush();
            }
        }
    }

    public function removeAddonPicture($addonType, $addon)
    {
        $image = $addon->getImage();

        $addon->setImage('');

        $this->_manager->persist($addon);

        $this->_manager->flush();

        $this->_fileUpload->removeAddonImage($addonType, $image);
    }

    public function removeAddon($addonType, $addon)
    {
        $addonImage = $addon->getImage();

        $this->_manager->remove($addon);

        $this->_manager->flush();

        $this->_fileUpload->removeAddonImage($addonType, $addonImage);
    }

    /* END\Addons */

    /* News */

    public function createNews($data, $file)
    {
        //DataCraft
        $data['news'] = ( !empty($data['news']) ) ? $data['news'] : [];
        $data['news'] = $this->_CRUDNews->combineNews($data['news']);

        $news = $this->_CRUDNews->setNews(NULL, $data['news']);

        $this->_manager->persist($news);

        $this->_manager->flush();

        //FileCraft
        if( !empty($file['file']['image']) )
        {
            $imageName = $this->_fileUpload->saveNewsImage($file['file']['image'], $news->getId());

            $news = $this->_CRUDNews->setNewsImages($news, $imageName);

            $this->_manager->persist($news);

            $this->_manager->flush();
        }

        return $news->getId();
    }

    public function updateNews($news, $data, $file)
    {
        //DataCraft
        $data['news'] = ( !empty($data['news']) ) ? $data['news'] : [];
        $data['news'] = $this->_CRUDNews->combineNews($data['news']);

        $news = $this->_CRUDNews->setNews($news, $data['news']);

        $this->_manager->persist($news);

        $this->_manager->flush();

        //FileCraft
        if( !empty($file['file']['image']) )
        {
            $imageName = $this->_fileUpload->saveNewsImage($file['file']['image'], $news->getId());

            $news = $this->_CRUDNews->setNewsImages($news, $imageName);

            $this->_manager->persist($news);

            $this->_manager->flush();
        }

        return $news->getId();
    }

    public function removeNewsPicture($news, $newsId)
    {
        $imageOriginal = $news->getImageOriginal();
        $imageThumb    = $news->getImageThumb();

        $news->setImageOriginal('')
            ->setImageThumb('');

        $this->_manager->persist($news);

        $this->_manager->flush();

        $this->_fileUpload->removeNewsImage([$imageOriginal, $imageThumb]);
    }

    public function deleteNews($news)
    {
        $imageOriginal = $news->getImageOriginal();
        $imageThumb    = $news->getImageThumb();

        $this->_manager->remove($news);

        $this->_manager->flush();

        $this->_fileUpload->removeNewsImage([$imageOriginal, $imageThumb]);
    }

    /* END\News */

    /* FAQ */

    public function createFaq($data)
    {
        //DataCraft
        $data['faq'] = ( !empty($data['faq']) ) ? $data['faq'] : [];
        $data['faq'] = $this->_CRUDFaq->combineFaq($data['faq']);

        $faq = $this->_CRUDFaq->setFaq(NULL, $data['faq']);

        $this->_manager->persist($faq);

        $this->_manager->flush();

        return $faq->getId();
    }

    public function updateFaq($faq, $data)
    {
        //DataCraft
        $data['faq'] = ( !empty($data['faq']) ) ? $data['faq'] : [];
        $data['faq'] = $this->_CRUDFaq->combineFaq($data['faq']);

        $faq = $this->_CRUDFaq->setFaq($faq, $data['faq']);

        $this->_manager->persist($faq);

        $this->_manager->flush();

        return $faq->getId();
    }

    public function deleteFaq($faq)
    {
        $this->_manager->remove($faq);

        $this->_manager->flush();
    }

    /* END\FAQ */

    /* Promotions */

    public function updatePromotions($files)
    {
        foreach($files['files'] as $image)
        {
            $imageName = $this->_fileUpload->savePromotionImage($image);

            $promotion = $this->_CRUDPromotion->setPromotion($imageName);

            $this->_manager->persist($promotion);

            $this->_manager->flush();
        }
    }

    public function deletePromotion($promotion)
    {
        $image = $promotion->getImage();

        $this->_manager->remove($promotion);

        $this->_manager->flush();

        $this->_fileUpload->removePromotionImage($image);
    }

    /* END\Promotions */

    private function getThematic($id)
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Shop\Thematic')
            ->find($id);
    }

    private function getCategory($id)
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Shop\Category')
            ->find($id);
    }

    public function setProductCurrentValue($productId)
    {
        $minPrice = $this->_manager
            ->getRepository(self::BUNDLE . '\Shop\ProductItem')
            ->findMinPriceByProduct($productId);

        $product = $this->_manager
            ->getRepository(self::BUNDLE . '\Shop\Product')
            ->find($productId);

        $product->setCurrentPrice($minPrice);

        $this->_manager->persist($product);

        $this->_manager->flush();
    }
}