<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/Shop/ItemSpecificationFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM\Shop;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use ATrophy\Entity\Shop\ItemSpecification;

class ItemSpecificationFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $item_specification = (new ItemSpecification)
            ->setColor("Золотой")
            ->setColorTouch("Синий")
            ->setHeight(15.00)
            ->setDiameterGoblet(5.00)
            ->setDiameterMedal(NULL)
            ->setDiameterToken(25.00)
            ->setStand(NULL)
            ->setProductItem($manager->merge($this->getReference('product_item_1_1_1')));
        $manager->persist($item_specification);

        $item_specification = (new ItemSpecification)
            ->setColor("Серебрянный")
            ->setColorTouch("Синий")
            ->setHeight(20.00)
            ->setDiameterGoblet(15.00)
            ->setDiameterMedal(NULL)
            ->setDiameterToken(25.00)
            ->setStand(NULL)
            ->setProductItem($manager->merge($this->getReference('product_item_1_1_2')));
        $manager->persist($item_specification);

        $item_specification = (new ItemSpecification)
            ->setColor("Бронзовый")
            ->setColorTouch("Синий")
            ->setHeight(30.00)
            ->setDiameterGoblet(25.00)
            ->setDiameterMedal(NULL)
            ->setDiameterToken(50.00)
            ->setStand(NULL)
            ->setProductItem($manager->merge($this->getReference('product_item_1_1_3')));
        $manager->persist($item_specification);

        //---

        $item_specification = (new ItemSpecification)
            ->setColor("Золотой")
            ->setColorTouch("Зеленый")
            ->setHeight(10.00)
            ->setDiameterGoblet(20.00)
            ->setDiameterMedal(NULL)
            ->setDiameterToken(25.00)
            ->setStand(NULL)
            ->setProductItem($manager->merge($this->getReference('product_item_1_2_1')));
        $manager->persist($item_specification);

        //---

        $item_specification = (new ItemSpecification)
            ->setColor(NULL)
            ->setColorTouch(NULL)
            ->setHeight(NULL)
            ->setDiameterGoblet(NULL)
            ->setDiameterMedal(25.00)
            ->setDiameterToken(NULL)
            ->setStand(NULL)
            ->setProductItem($manager->merge($this->getReference('product_item_2_1_1')));
        $manager->persist($item_specification);

        //---

        $item_specification = (new ItemSpecification)
            ->setColor(NULL)
            ->setColorTouch(NULL)
            ->setHeight(10.00)
            ->setDiameterGoblet(NULL)
            ->setDiameterMedal(NULL)
            ->setDiameterToken(NULL)
            ->setStand(5.00)
            ->setProductItem($manager->merge($this->getReference('product_item_3_1_1')));
        $manager->persist($item_specification);

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}