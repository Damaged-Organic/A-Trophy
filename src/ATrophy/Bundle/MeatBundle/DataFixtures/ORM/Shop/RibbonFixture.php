<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/Shop/RibbonFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM\Shop;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use ATrophy\Entity\Shop\Ribbon;

class RibbonFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $ribbon = (new Ribbon)
            ->setTitle("Лента украинская")
            ->setWidth(20.00)
            ->setPrice(4.99)
            ->setImage('ribbon.jpg');
        $manager->persist($ribbon);

        $ribbon = (new Ribbon)
            ->setTitle("Лента белорусская")
            ->setWidth(10.00)
            ->setPrice(3.99)
            ->setImage('ribbon.jpg');
        $manager->persist($ribbon);

        $manager->flush();
    }
}