<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/Shop/ProductFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM\Shop;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use ATrophy\Entity\Shop\Product;

class ProductFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $product_1_1 = (new Product)
            ->setTitle("Кубок 1")
            ->setImage("1.jpg")
            ->setImageSquare("1.jpg")
            ->setImageThumb("1.jpg")
            ->setRatingVotes(10)
            ->setRatingScore(3.5)
            ->setViews(5)
            ->setIsVisible(TRUE)
            ->setCurrentPrice(15.99)
            ->setKitPrice(45.99)
            ->setCategory($manager->merge($this->getReference('category_1')))
            ->setSubcategory($manager->merge($this->getReference('category_5')))
            ->setThematic($manager->merge($this->getReference('thematic_0')));
        $manager->persist($product_1_1);

        $product_1_2 = (new Product)
            ->setTitle("Кубок 2")
            ->setImage("2.jpg")
            ->setImageSquare("2.jpg")
            ->setImageThumb("2.jpg")
            ->setRatingVotes(10)
            ->setRatingScore(3.5)
            ->setViews(5)
            ->setIsVisible(TRUE)
            ->setCurrentPrice(29.99)
            ->setCategory($manager->merge($this->getReference('category_1')))
            ->setSubcategory($manager->merge($this->getReference('category_6')))
            ->setThematic($manager->merge($this->getReference('thematic_0')));
        $manager->persist($product_1_2);

        $product_1_3 = (new Product)
            ->setTitle("Кубок 3")
            ->setImage("3.jpg")
            ->setImageSquare("3.jpg")
            ->setImageThumb("3.jpg")
            ->setRatingVotes(10)
            ->setRatingScore(3.5)
            ->setViews(5)
            ->setIsVisible(TRUE)
            ->setCurrentPrice(43.99)
            ->setCategory($manager->merge($this->getReference('category_1')))
            ->setSubcategory($manager->merge($this->getReference('category_7')))
            ->setThematic($manager->merge($this->getReference('thematic_0')));
        $manager->persist($product_1_3);

        $product_1_4 = (new Product)
            ->setTitle("Кубок 4")
            ->setImage("1.jpg")
            ->setImageSquare("1.jpg")
            ->setImageThumb("1.jpg")
            ->setRatingVotes(10)
            ->setRatingScore(3.5)
            ->setViews(5)
            ->setIsVisible(TRUE)
            ->setCurrentPrice(23.99)
            ->setCategory($manager->merge($this->getReference('category_1')))
            ->setSubcategory($manager->merge($this->getReference('category_8')))
            ->setThematic($manager->merge($this->getReference('thematic_4')));
        $manager->persist($product_1_4);

        $product_1_5 = (new Product)
            ->setTitle("Кубок 5")
            ->setImage("no.jpg")
            ->setImageSquare("no.jpg")
            ->setImageThumb("no.jpg")
            ->setRatingVotes(10)
            ->setRatingScore(3.5)
            ->setViews(5)
            ->setIsVisible(TRUE)
            ->setCurrentPrice(65.99)
            ->setCategory($manager->merge($this->getReference('category_1')))
            ->setSubcategory($manager->merge($this->getReference('category_9')))
            ->setThematic($manager->merge($this->getReference('thematic_5')));
        $manager->persist($product_1_5);

        //---

        $product_2_1 = (new Product)
            ->setTitle("Медаль 1")
            ->setImage("1.jpg")
            ->setImageSquare("1.jpg")
            ->setImageThumb("1.jpg")
            ->setRatingVotes(5)
            ->setRatingScore(4.5)
            ->setViews(10)
            ->setIsVisible(TRUE)
            ->setCurrentPrice(11.20)
            ->setCategory($manager->merge($this->getReference('category_2')))
            ->setSubcategory(NULL)
            ->setThematic($manager->merge($this->getReference('thematic_0')));
        $manager->persist($product_2_1);

        $product_2_2 = (new Product)
            ->setTitle("Медаль 1")
            ->setImage("2.jpg")
            ->setImageSquare("2.jpg")
            ->setImageThumb("2.jpg")
            ->setRatingVotes(5)
            ->setRatingScore(4.5)
            ->setViews(10)
            ->setIsVisible(TRUE)
            ->setCurrentPrice(12.50)
            ->setCategory($manager->merge($this->getReference('category_2')))
            ->setSubcategory(NULL)
            ->setThematic($manager->merge($this->getReference('thematic_5')));
        $manager->persist($product_2_2);

        //---

        $product_3_1 = (new Product)
            ->setTitle("Статуэтка 1")
            ->setImage("1.jpg")
            ->setImageSquare("1.jpg")
            ->setImageThumb("1.jpg")
            ->setRatingVotes(1)
            ->setRatingScore(5.0)
            ->setViews(15)
            ->setIsVisible(TRUE)
            ->setCurrentPrice(23.23)
            ->setCategory($manager->merge($this->getReference('category_3')))
            ->setSubcategory($manager->merge($this->getReference('category_10')))
            ->setThematic($manager->merge($this->getReference('thematic_20')));
        $manager->persist($product_3_1);

        $product_3_2 = (new Product)
            ->setTitle("Статуэтка 2")
            ->setImage("2.jpg")
            ->setImageSquare("2.jpg")
            ->setImageThumb("2.jpg")
            ->setRatingVotes(1)
            ->setRatingScore(5.0)
            ->setViews(15)
            ->setIsVisible(TRUE)
            ->setCurrentPrice(11.23)
            ->setCategory($manager->merge($this->getReference('category_3')))
            ->setSubcategory($manager->merge($this->getReference('category_11')))
            ->setThematic($manager->merge($this->getReference('thematic_21')));
        $manager->persist($product_3_2);

        //---

        $product_4_1 = (new Product)
            ->setTitle("Награда 1")
            ->setImage("1.jpg")
            ->setImageSquare("1.jpg")
            ->setImageThumb("1.jpg")
            ->setRatingVotes(10)
            ->setRatingScore(2.0)
            ->setViews(20)
            ->setIsVisible(TRUE)
            ->setCurrentPrice(4.99)
            ->setCategory($manager->merge($this->getReference('category_4')))
            ->setSubcategory($manager->merge($this->getReference('category_12')))
            ->setThematic($manager->merge($this->getReference('thematic_30')));
        $manager->persist($product_4_1);

        $product_4_2 = (new Product)
            ->setTitle("Награда 2")
            ->setImage("3.jpg")
            ->setImageSquare("3.jpg")
            ->setImageThumb("3.jpg")
            ->setRatingVotes(10)
            ->setRatingScore(2.0)
            ->setViews(20)
            ->setIsVisible(TRUE)
            ->setCurrentPrice(23.99)
            ->setCategory($manager->merge($this->getReference('category_4')))
            ->setSubcategory($manager->merge($this->getReference('category_13')))
            ->setThematic($manager->merge($this->getReference('thematic_31')));
        $manager->persist($product_4_2);

        $product_4_3 = (new Product)
            ->setTitle("Награда 3")
            ->setImage("3.jpg")
            ->setImageSquare("3.jpg")
            ->setImageThumb("3.jpg")
            ->setRatingVotes(10)
            ->setRatingScore(2.0)
            ->setViews(20)
            ->setIsVisible(TRUE)
            ->setCurrentPrice(11.99)
            ->setCategory($manager->merge($this->getReference('category_4')))
            ->setSubcategory($manager->merge($this->getReference('category_14')))
            ->setThematic($manager->merge($this->getReference('thematic_32')));
        $manager->persist($product_4_3);

        $product_4_4 = (new Product)
            ->setTitle("Награда 4")
            ->setImage("3.jpg")
            ->setImageSquare("3.jpg")
            ->setImageThumb("3.jpg")
            ->setRatingVotes(10)
            ->setRatingScore(2.0)
            ->setViews(20)
            ->setIsVisible(TRUE)
            ->setCurrentPrice(34.99)
            ->setCategory($manager->merge($this->getReference('category_4')))
            ->setSubcategory($manager->merge($this->getReference('category_15')))
            ->setThematic($manager->merge($this->getReference('thematic_33')));
        $manager->persist($product_4_4);

        $product_4_5 = (new Product)
            ->setTitle("Награда 5")
            ->setImage("3.jpg")
            ->setImageSquare("3.jpg")
            ->setImageThumb("3.jpg")
            ->setRatingVotes(10)
            ->setRatingScore(2.0)
            ->setViews(20)
            ->setIsVisible(TRUE)
            ->setCurrentPrice(12.99)
            ->setCategory($manager->merge($this->getReference('category_4')))
            ->setSubcategory($manager->merge($this->getReference('category_16')))
            ->setThematic($manager->merge($this->getReference('thematic_0')));
        $manager->persist($product_4_5);

        $manager->flush();

        $this->addReference('product_1_1', $product_1_1);
        $this->addReference('product_1_2', $product_1_2);
        $this->addReference('product_1_3', $product_1_3);
        $this->addReference('product_1_4', $product_1_4);
        $this->addReference('product_1_5', $product_1_5);

        $this->addReference('product_2_1', $product_2_1);
        $this->addReference('product_2_2', $product_2_2);

        $this->addReference('product_3_1', $product_3_1);
        $this->addReference('product_3_2', $product_3_2);

        $this->addReference('product_4_1', $product_4_1);
        $this->addReference('product_4_2', $product_4_2);
        $this->addReference('product_4_3', $product_4_3);
        $this->addReference('product_4_4', $product_4_4);
        $this->addReference('product_4_5', $product_4_5);
    }

    public function getOrder()
    {
        return 2;
    }
}