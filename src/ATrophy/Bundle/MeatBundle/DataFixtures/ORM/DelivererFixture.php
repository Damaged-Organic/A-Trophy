<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/DelivererFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use ATrophy\Entity\Meat\Deliverer;

class DelivererFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $deliverer = (new Deliverer)
            ->setRowOrder(1)
            ->setName("Нова Пошта")
            ->setImage("delivery-1.jpg");
        $manager->persist($deliverer);

        $deliverer = (new Deliverer)
            ->setRowOrder(2)
            ->setName("Gunsel")
            ->setImage("delivery-2.jpg");
        $manager->persist($deliverer);

        $deliverer = (new Deliverer)
            ->setRowOrder(3)
            ->setName("Інтайм")
            ->setImage("delivery-3.jpg");
        $manager->persist($deliverer);

        $deliverer = (new Deliverer)
            ->setRowOrder(4)
            ->setName("Nameless")
            ->setImage("delivery-4.jpg");
        $manager->persist($deliverer);

        $manager->flush();
    }
}