<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/Shop/ProductItemFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM\Shop;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use ATrophy\Entity\Shop\ProductItem;

class ProductItemFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $product_item_1_1_1 = (new ProductItem)
            ->setArticle("К-1000")
            ->setPrice(15.99)
            ->setPricePromo(NULL)
            ->setStock(TRUE)
            ->setProduct($manager->merge($this->getReference('product_1_1')));
        $manager->persist($product_item_1_1_1);

        $product_item_1_1_2 = (new ProductItem)
            ->setArticle("К-1001")
            ->setPrice(16.99)
            ->setPricePromo(NULL)
            ->setStock(TRUE)
            ->setProduct($manager->merge($this->getReference('product_1_1')));
        $manager->persist($product_item_1_1_2);

        $product_item_1_1_3 = (new ProductItem)
            ->setArticle("К-1002")
            ->setPrice(17.99)
            ->setPricePromo(NULL)
            ->setStock(TRUE)
            ->setProduct($manager->merge($this->getReference('product_1_1')));
        $manager->persist($product_item_1_1_3);

        $product_item_1_2_1 = (new ProductItem)
            ->setArticle("К-2000")
            ->setPrice(39.99)
            ->setPricePromo(29.99)
            ->setStock(TRUE)
            ->setProduct($manager->merge($this->getReference('product_1_2')));
        $manager->persist($product_item_1_2_1);

        $product_item_1_3_1 = (new ProductItem)
            ->setArticle("К-3000")
            ->setPrice(43.99)
            ->setPricePromo(NULL)
            ->setStock(TRUE)
            ->setProduct($manager->merge($this->getReference('product_1_3')));
        $manager->persist($product_item_1_3_1);

        $product_item_1_4_1 = (new ProductItem)
            ->setArticle("К-4000")
            ->setPrice(23.99)
            ->setPricePromo(NULL)
            ->setStock(TRUE)
            ->setProduct($manager->merge($this->getReference('product_1_4')));
        $manager->persist($product_item_1_4_1);

        $product_item_1_5_1 = (new ProductItem)
            ->setArticle("К-4000")
            ->setPrice(65.99)
            ->setPricePromo(NULL)
            ->setStock(TRUE)
            ->setProduct($manager->merge($this->getReference('product_1_5')));
        $manager->persist($product_item_1_5_1);

        //---

        $product_item_2_1_1 = (new ProductItem)
            ->setArticle("M-1000")
            ->setPrice(11.20)
            ->setPricePromo(NULL)
            ->setStock(TRUE)
            ->setProduct($manager->merge($this->getReference('product_2_1')));
        $manager->persist($product_item_2_1_1);

        $product_item_2_2_1 = (new ProductItem)
            ->setArticle("M-2000")
            ->setPrice(12.50)
            ->setPricePromo(NULL)
            ->setStock(TRUE)
            ->setProduct($manager->merge($this->getReference('product_2_2')));
        $manager->persist($product_item_2_2_1);

        //---

        $product_item_3_1_1 = (new ProductItem)
            ->setArticle("S-1000")
            ->setPrice(42.42)
            ->setPricePromo(23.23)
            ->setStock(FALSE)
            ->setProduct($manager->merge($this->getReference('product_3_1')));
        $manager->persist($product_item_3_1_1);

        $product_item_3_1_2 = (new ProductItem)
            ->setArticle("S-1001")
            ->setPrice(56.42)
            ->setPricePromo(NULL)
            ->setStock(TRUE)
            ->setProduct($manager->merge($this->getReference('product_3_1')));
        $manager->persist($product_item_3_1_2);

        $product_item_3_2_1 = (new ProductItem)
            ->setArticle("S-2000")
            ->setPrice(15.42)
            ->setPricePromo(11.23)
            ->setStock(FALSE)
            ->setProduct($manager->merge($this->getReference('product_3_2')));
        $manager->persist($product_item_3_2_1);

        //---

        $product_item_4_1_1 = (new ProductItem)
            ->setArticle("A-1000")
            ->setPrice(5.99)
            ->setPricePromo(4.99)
            ->setStock(FALSE)
            ->setProduct($manager->merge($this->getReference('product_4_1')));
        $manager->persist($product_item_4_1_1);

        $product_item_4_1_2 = (new ProductItem)
            ->setArticle("A-1001")
            ->setPrice(10.99)
            ->setPricePromo(NULL)
            ->setStock(FALSE)
            ->setProduct($manager->merge($this->getReference('product_4_1')));
        $manager->persist($product_item_4_1_2);

        $product_item_4_2_1 = (new ProductItem)
            ->setArticle("A-2000")
            ->setPrice(23.99)
            ->setPricePromo(NULL)
            ->setStock(FALSE)
            ->setProduct($manager->merge($this->getReference('product_4_2')));
        $manager->persist($product_item_4_2_1);

        $product_item_4_3_1 = (new ProductItem)
            ->setArticle("A-3000")
            ->setPrice(11.99)
            ->setPricePromo(NULL)
            ->setStock(FALSE)
            ->setProduct($manager->merge($this->getReference('product_4_3')));
        $manager->persist($product_item_4_3_1);

        $product_item_4_4_1 = (new ProductItem)
            ->setArticle("A-4000")
            ->setPrice(34.99)
            ->setPricePromo(NULL)
            ->setStock(FALSE)
            ->setProduct($manager->merge($this->getReference('product_4_4')));
        $manager->persist($product_item_4_4_1);

        $product_item_4_5_1 = (new ProductItem)
            ->setArticle("A-5000")
            ->setPrice(12.99)
            ->setPricePromo(NULL)
            ->setStock(FALSE)
            ->setProduct($manager->merge($this->getReference('product_4_5')));
        $manager->persist($product_item_4_5_1);

        $manager->flush();

        $this->addReference('product_item_1_1_1', $product_item_1_1_1);
        $this->addReference('product_item_1_1_2', $product_item_1_1_2);
        $this->addReference('product_item_1_1_3', $product_item_1_1_3);
        $this->addReference('product_item_1_2_1', $product_item_1_2_1);
        $this->addReference('product_item_1_3_1', $product_item_1_3_1);
        $this->addReference('product_item_1_4_1', $product_item_1_4_1);
        $this->addReference('product_item_1_5_1', $product_item_1_5_1);

        $this->addReference('product_item_2_1_1', $product_item_2_1_1);
        $this->addReference('product_item_2_2_1', $product_item_2_2_1);

        $this->addReference('product_item_3_1_1', $product_item_3_1_1);
        $this->addReference('product_item_3_1_2', $product_item_3_1_2);
        $this->addReference('product_item_3_2_1', $product_item_3_2_1);

        $this->addReference('product_item_4_1_1', $product_item_4_1_1);
        $this->addReference('product_item_4_1_2', $product_item_4_1_2);
        $this->addReference('product_item_4_2_1', $product_item_4_2_1);
        $this->addReference('product_item_4_3_1', $product_item_4_3_1);
        $this->addReference('product_item_4_4_1', $product_item_4_4_1);
        $this->addReference('product_item_4_5_1', $product_item_4_5_1);
    }

    public function getOrder()
    {
        return 3;
    }
}