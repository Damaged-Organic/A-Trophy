<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/Shop/TokenFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM\Shop;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use ATrophy\Entity\Shop\Token;

class TokenFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $token = (new Token)
            ->setTitle("Жетон 1")
            ->setColor("Золотой")
            ->setDiameter(25.00)
            ->setPrice(3.99)
            ->setImage('token.jpg')
            ->setThematic($manager->merge($this->getReference('thematic_1')));
        $manager->persist($token);

        $token = (new Token)
            ->setTitle("Жетон 2")
            ->setColor("Серебряный")
            ->setDiameter(25.00)
            ->setPrice(3.99)
            ->setImage('token.jpg')
            ->setThematic($manager->merge($this->getReference('thematic_10')));
        $manager->persist($token);

        $token = (new Token)
            ->setTitle("Жетон 3")
            ->setColor("Бронзовый")
            ->setDiameter(25.00)
            ->setPrice(3.99)
            ->setImage('token.jpg')
            ->setThematic($manager->merge($this->getReference('thematic_20')));
        $manager->persist($token);

        $token = (new Token)
            ->setTitle("Жетон 4")
            ->setColor("Серый")
            ->setDiameter(50.00)
            ->setPrice(6.99)
            ->setImage('token.jpg')
            ->setThematic($manager->merge($this->getReference('thematic_30')));
        $manager->persist($token);

        $token = (new Token)
            ->setTitle("Жетон 5")
            ->setColor("Белый")
            ->setDiameter(50.00)
            ->setPrice(6.99)
            ->setImage('token.jpg')
            ->setThematic($manager->merge($this->getReference('thematic_40')));
        $manager->persist($token);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}