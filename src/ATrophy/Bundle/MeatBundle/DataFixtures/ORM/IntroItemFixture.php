<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/IntroItemFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use ATrophy\Entity\Meat\IntroItem;

class IntroItemFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $introItem = (new IntroItem)
            ->setRowOrder(1)
            ->setCategorySubdirectory("goblets")
            ->setImageOriginal("goblets-original.jpg")
            ->setImageFiltered("goblets.jpg")
            ->setTitle("Кубки")
            ->setText("В нашем каталоге представлен широкий выбор кубков различных категорий, от эконом-класса до элитных моделей итальянского производителя Golden Life");
        $manager->persist($introItem);

        $introItem = (new IntroItem)
            ->setRowOrder(2)
            ->setCategorySubdirectory("medals")
            ->setImageOriginal("medals-original.jpg")
            ->setImageFiltered("medals.jpg")
            ->setTitle("Медали")
            ->setText("У нас вы можете найти медали разных размеров и стилей, которые подойдут к любому вашему мероприятию");
        $manager->persist($introItem);

        $introItem = (new IntroItem)
            ->setRowOrder(3)
            ->setCategorySubdirectory("statuettes")
            ->setImageOriginal("statuettes-original.jpg")
            ->setImageFiltered("statuettes.jpg")
            ->setTitle("Статуэтки")
            ->setText("В нашем каталоге вы найдете статуэтки не только для спортивных событий, но и те, которые украсят ваш фестиваль, корпоратив или любое другое событие");
        $manager->persist($introItem);

        $introItem = (new IntroItem)
            ->setRowOrder(4)
            ->setCategorySubdirectory("awards")
            ->setImageOriginal("awards-original.jpg")
            ->setImageFiltered("awards.jpg")
            ->setTitle("Награды")
            ->setText("Награды - это широкий выбор продукции, которые включают изделия из стекла, наградные тарелки и плакетки");
        $manager->persist($introItem);

        $manager->flush();
    }
}