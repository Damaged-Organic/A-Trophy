<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/DirectoryFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use ATrophy\Entity\Common\Directory;

class DirectoryFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $directory = (new Directory)
            ->setRowOrder(1)
            ->setRoute("atrophy_meat_homepage")
            ->setTitle("Главная");
        $manager->persist($directory);
		
		$directory = (new Directory)
            ->setRowOrder(2)
            ->setRoute("atrophy_meat_about_us")
            ->setTitle("О компании");
        $manager->persist($directory);
		
		$directory = (new Directory)
            ->setRowOrder(3)
            ->setRoute("atrophy_meat_promotions")
            ->setTitle("Акции");
        $manager->persist($directory);
		
		$directory = (new Directory)
            ->setRowOrder(4)
            ->setRoute("atrophy_meat_shop")
            ->setTitle("Магазин");
        $manager->persist($directory);
		
		$directory = (new Directory)
            ->setRowOrder(5)
            ->setRoute("atrophy_meat_thematics")
            ->setTitle("Тематики");
        $manager->persist($directory);
		
		$directory = (new Directory)
            ->setRowOrder(6)
            ->setRoute("atrophy_meat_news")
            ->setTitle("Новости");
        $manager->persist($directory);
		
		$directory = (new Directory)
            ->setRowOrder(7)
            ->setRoute("atrophy_meat_delivery_and_payment")
            ->setTitle("Доставка и Оплата");
        $manager->persist($directory);
		
		$directory = (new Directory)
            ->setRowOrder(8)
            ->setRoute("atrophy_meat_faq")
            ->setTitle("Вопрос-ответ");
        $manager->persist($directory);
		
		$directory = (new Directory)
            ->setRowOrder(9)
            ->setRoute("atrophy_meat_contacts")
            ->setTitle("Контакты");
        $manager->persist($directory);

        $manager->flush();
    }
}