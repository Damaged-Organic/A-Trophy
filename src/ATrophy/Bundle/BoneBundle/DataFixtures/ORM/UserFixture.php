<?php
// src/ATrophy/Bundle/BoneBundle/DataFixtures/ORM/UserFixture.php
namespace ATrophy\Bundle\BoneBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;

use ATrophy\Entity\Bone\User;

class UserFixture implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = NULL)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user = (new User)
            ->setUsername("Администратор")
            ->setEmail("oleksiiovcharenko@gmail.com")
            ->setSalt(sha1(uniqid('', TRUE)));

        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        $user->setPassword($encoder->encodePassword('#_@-Tr0phy_#', $user->getSalt()));

        $manager->persist($user);

        $manager->flush();
    }
}