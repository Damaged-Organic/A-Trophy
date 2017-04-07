<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/ContactFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use ATrophy\Entity\Common\Contact;

class ContactFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $contact = (new Contact)
            ->setType('address')
            ->setCredential("г. Киев, ул. Васильковская, д. 14 (Офисный центр \"Stend\")");
        $manager->persist($contact);

        $contact = (new Contact)
            ->setType('phone')
            ->setCredential("+380 (63) 725-27-05");
        $manager->persist($contact);

        $contact = (new Contact)
            ->setType('phone')
            ->setCredential("+380 (66) 308-48-32");
        $manager->persist($contact);

        $contact = (new Contact)
            ->setType('email')
            ->setCredential("office@a-trophy.com.ua");
        $manager->persist($contact);

        $manager->flush();
    }
}