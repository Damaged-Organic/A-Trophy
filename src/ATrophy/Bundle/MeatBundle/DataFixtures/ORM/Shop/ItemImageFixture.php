<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/Shop/ItemImageFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM\Shop;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use ATrophy\Entity\Shop\ItemImage;

class ItemImageFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $item_image = (new ItemImage)
            ->setImage("item_1.jpg")
            ->setImageSquare("item_1.jpg")
            ->setImageThumb("item_1.jpg")
            ->setProductItem($manager->merge($this->getReference('product_item_1_1_1')));
        $manager->persist($item_image);

        $item_image = (new ItemImage)
            ->setImage("item_1.jpg")
            ->setImageSquare("item_1.jpg")
            ->setImageThumb("item_1.jpg")
            ->setProductItem($manager->merge($this->getReference('product_item_1_1_2')));
        $manager->persist($item_image);

        $item_image = (new ItemImage)
            ->setImage("item_1.jpg")
            ->setImageSquare("item_1.jpg")
            ->setImageThumb("item_1.jpg")
            ->setProductItem($manager->merge($this->getReference('product_item_1_1_3')));
        $manager->persist($item_image);

        $item_image = (new ItemImage)
            ->setImage("item_2.jpg")
            ->setImageSquare("item_2.jpg")
            ->setImageThumb("item_2.jpg")
            ->setProductItem($manager->merge($this->getReference('product_item_1_2_1')));
        $manager->persist($item_image);

        $item_image = (new ItemImage)
            ->setImage("item_3.jpg")
            ->setImageSquare("item_3.jpg")
            ->setImageThumb("item_3.jpg")
            ->setProductItem($manager->merge($this->getReference('product_item_1_3_1')));
        $manager->persist($item_image);

        //---

        $item_image = (new ItemImage)
            ->setImage("item_1.jpg")
            ->setImageSquare("item_1.jpg")
            ->setImageThumb("item_1.jpg")
            ->setProductItem($manager->merge($this->getReference('product_item_2_1_1')));
        $manager->persist($item_image);

        $item_image = (new ItemImage)
            ->setImage("item_2.jpg")
            ->setImageSquare("item_2.jpg")
            ->setImageThumb("item_2.jpg")
            ->setProductItem($manager->merge($this->getReference('product_item_2_2_1')));
        $manager->persist($item_image);

        //---

        $item_image = (new ItemImage)
            ->setImage("item_1.jpg")
            ->setImageSquare("item_1.jpg")
            ->setImageThumb("item_1.jpg")
            ->setProductItem($manager->merge($this->getReference('product_item_3_1_1')));
        $manager->persist($item_image);

        $item_image = (new ItemImage)
            ->setImage("item_2.jpg")
            ->setImageSquare("item_2.jpg")
            ->setImageThumb("item_2.jpg")
            ->setProductItem($manager->merge($this->getReference('product_item_3_2_1')));
        $manager->persist($item_image);

        //---

        $item_image = (new ItemImage)
            ->setImage("item_1.jpg")
            ->setImageSquare("item_1.jpg")
            ->setImageThumb("item_1.jpg")
            ->setProductItem($manager->merge($this->getReference('product_item_4_1_1')));
        $manager->persist($item_image);

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}