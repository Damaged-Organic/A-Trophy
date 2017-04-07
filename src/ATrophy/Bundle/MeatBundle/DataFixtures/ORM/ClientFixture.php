<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/ClientFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM;

use ATrophy\Entity\Meat\Client;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

class ClientFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $client = (new Client)
            ->setRowOrder(1)
            ->setName("Мотор Сич")
            ->setImage("clients-1.jpg");
        $manager->persist($client);

        $client = (new Client)
            ->setRowOrder(2)
            ->setName("НОК Украины")
            ->setImage("clients-2.jpg");
        $manager->persist($client);

        $client = (new Client)
            ->setRowOrder(3)
            ->setName("Группа компаний Метинвест")
            ->setImage("clients-3.jpg");
        $manager->persist($client);

        $client = (new Client)
            ->setRowOrder(4)
            ->setName("КСУ")
            ->setImage("clients-4.jpg");
        $manager->persist($client);

        $client = (new Client)
            ->setRowOrder(5)
            ->setName("ЦКВНУ")
            ->setImage("clients-5.jpg");
        $manager->persist($client);

        $client = (new Client)
            ->setRowOrder(6)
            ->setName("Мариупольский торговый порт")
            ->setImage("clients-6.jpg");
        $manager->persist($client);

        $client = (new Client)
            ->setRowOrder(7)
            ->setName("Эпицентр")
            ->setImage("clients-7.jpg");
        $manager->persist($client);

        $client = (new Client)
            ->setRowOrder(8)
            ->setName("First Golf & Country Club")
            ->setImage("clients-8.jpg");
        $manager->persist($client);

        $client = (new Client)
            ->setRowOrder(9)
            ->setName("Министерство молодежи и спорта")
            ->setImage("clients-9.jpg");
        $manager->persist($client);

        $manager->flush();
    }
}