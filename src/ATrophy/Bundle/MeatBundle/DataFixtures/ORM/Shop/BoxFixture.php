<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/Shop/BoxFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM\Shop;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use ATrophy\Entity\Shop\Box;

class BoxFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $box = (new Box)
            ->setTitle("Коробка 1")
            ->setColor("Красный")
            ->setSize(15.00)
            ->setPrice(9.99)
            ->setImage('box.jpg');
        $manager->persist($box);

        $box = (new Box)
            ->setTitle("Коробка 2")
            ->setColor("Синий")
            ->setSize(20.00)
            ->setPrice(10.99)
            ->setImage('box.jpg');
        $manager->persist($box);

        $manager->flush();
    }
}