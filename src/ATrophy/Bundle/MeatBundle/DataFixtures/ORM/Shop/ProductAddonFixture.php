<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/Shop/ProductAddonFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM\Shop;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use ATrophy\Entity\Shop\ProductAddon;

class ProductAddonFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $product_addon = (new ProductAddon)
            ->setHasStatuette(TRUE)
            ->setHasToken(TRUE)
            ->setHasTopToken(TRUE)
            ->setHasEtching(FALSE)
            ->setHasPlate(TRUE)
            ->setHasRibbon(FALSE)
            ->setHasBox(FALSE)
            ->setProduct($manager->merge($this->getReference('product_1_1')));
        $manager->persist($product_addon);

        $product_addon = (new ProductAddon)
            ->setHasStatuette(FALSE)
            ->setHasToken(TRUE)
            ->setHasTopToken(FALSE)
            ->setHasEtching(TRUE)
            ->setHasPlate(FALSE)
            ->setHasRibbon(TRUE)
            ->setHasBox(TRUE)
            ->setProduct($manager->merge($this->getReference('product_2_1')));
        $manager->persist($product_addon);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}