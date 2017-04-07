<?php
// src/ATrophy/Bundle/MeatBundle/DataFixtures/ORM/PromotionFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM;

use ATrophy\Entity\Meat\Promotion;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

class PromotionFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $promotion = (new Promotion)
            ->setCreated(time())
            ->setImage("1.jpg");
        $manager->persist($promotion);

        $manager->flush();
    }
}