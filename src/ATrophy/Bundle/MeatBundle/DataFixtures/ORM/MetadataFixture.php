<?php
// ATrophy/Entity/DataFixture/ORM/MetadataFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM;

use ATrophy\Entity\Common\Metadata;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

class MetadataFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $metadata = (new Metadata)
            ->setRoute("atrophy_meat_homepage")
            ->setTitle("A-Trophy - Главная")
            ->setRobots('index, follow');
        $manager->persist($metadata);
		
		$metadata = (new Metadata)
            ->setRoute("atrophy_meat_about_us")
            ->setTitle("О компании - A-Trophy")
            ->setRobots('index, follow');
        $manager->persist($metadata);
		
		$metadata = (new Metadata)
            ->setRoute("atrophy_meat_promotions")
            ->setTitle("Акции - A-Trophy")
            ->setRobots('index, follow');
        $manager->persist($metadata);
		
		$metadata = (new Metadata)
            ->setRoute("atrophy_meat_shop")
            ->setTitle("Магазин - A-Trophy")
            ->setRobots('index, follow');
        $manager->persist($metadata);
		
		$metadata = (new Metadata)
            ->setRoute("atrophy_meat_thematics")
            ->setTitle("Тематики - A-Trophy")
            ->setRobots('index, follow');
        $manager->persist($metadata);

        $metadata = (new Metadata)
            ->setRoute("atrophy_meat_model")
            ->setTitle("Товар - A-Trophy")
            ->setRobots('index, follow');
        $manager->persist($metadata);

        $metadata = (new Metadata)
            ->setRoute("atrophy_meat_promotions_model")
            ->setTitle("Товар - A-Trophy")
            ->setRobots('index, follow');
        $manager->persist($metadata);

        $metadata = (new Metadata)
            ->setRoute("atrophy_meat_shop_model")
            ->setTitle("Товар - A-Trophy")
            ->setRobots('index, follow');
        $manager->persist($metadata);

        $metadata = (new Metadata)
            ->setRoute("atrophy_meat_thematics_model")
            ->setTitle("Товар - A-Trophy")
            ->setRobots('index, follow');
        $manager->persist($metadata);
		
		$metadata = (new Metadata)
            ->setRoute("atrophy_meat_news")
            ->setTitle("Новости - A-Trophy")
            ->setRobots('index, follow');
        $manager->persist($metadata);

        $metadata = (new Metadata)
            ->setRoute("atrophy_meat_news_article")
            ->setTitle("Статья - A-Trophy")
            ->setRobots('index, follow');
        $manager->persist($metadata);

		$metadata = (new Metadata)
            ->setRoute("atrophy_meat_delivery_and_payment")
            ->setTitle("Доставка и Оплата - A-Trophy")
            ->setRobots('index, follow');
        $manager->persist($metadata);
		
		$metadata = (new Metadata)
            ->setRoute("atrophy_meat_faq")
            ->setTitle("Вопрос-ответ - A-Trophy")
            ->setRobots('index, follow');
        $manager->persist($metadata);
		
		$metadata = (new Metadata)
            ->setRoute("atrophy_meat_contacts")
            ->setTitle("Контакты - A-Trophy")
            ->setRobots('index, follow');
        $manager->persist($metadata);

        $metadata = (new Metadata)
            ->setRoute("atrophy_meat_search")
            ->setTitle("Поиск - A-Trophy")
            ->setRobots('index, follow');
        $manager->persist($metadata);

        $metadata = (new Metadata)
            ->setRoute("atrophy_meat_cart")
            ->setTitle("Корзина - A-Trophy")
            ->setRobots('noindex, nofollow');
        $manager->persist($metadata);

        $metadata = (new Metadata)
            ->setRoute("atrophy_meat_cart_checkout")
            ->setTitle("Оформление заказа - A-Trophy")
            ->setRobots('noindex, nofollow');
        $manager->persist($metadata);

        $manager->flush();
    }
}