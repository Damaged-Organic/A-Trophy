<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/Shop/CategoryFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM\Shop;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use ATrophy\Entity\Shop\Category;

class CategoryFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = [
            1 => [
                'level' => 0,
                'param' => 'goblets',
                'title' => "Кубки"
            ],
            2 => [
                'level' => 0,
                'param' => 'medals',
                'title' => "Медали"
            ],
            3 => [
                'level' => 0,
                'param' => 'statuettes',
                'title' => "Статуэтки"
            ],
            4 => [
                'level' => 0,
                'param' => 'awards',
                'title' => "Награды"
            ],
            5 => [
                'level' => 1,
                'param' => NULL,
                'title' => "Эконом"
            ],
            6 => [
                'level' => 1,
                'param' => NULL,
                'title' => "Стандарт"
            ],
            7 => [
                'level' => 1,
                'param' => NULL,
                'title' => "Элит"
            ],
            8 => [
                'level' => 1,
                'param' => NULL,
                'title' => "Престиж"
            ],
            9 => [
                'level' => 1,
                'param' => NULL,
                'title' => "Оригинальные"
            ],
            10 => [
                'level' => 3,
                'param' => NULL,
                'title' => "Пластиковые фигуры"
            ],
            11 => [
                'level' => 3,
                'param' => NULL,
                'title' => "Стенд-фигуры"
            ],
            12 => [
                'level' => 4,
                'param' => NULL,
                'title' => "Изделия из стекла"
            ],
            13 => [
                'level' => 4,
                'param' => NULL,
                'title' => "Наградные тарелки"
            ],
            14 => [
                'level' => 4,
                'param' => NULL,
                'title' => "Плакетки с накладками"
            ],
            15 => [
                'level' => 4,
                'param' => NULL,
                'title' => "Грамоты"
            ],
            16 => [
                'level' => 4,
                'param' => NULL,
                'title' => "Дипломы"
            ],
        ];

        foreach($data as $key => $value)
        {
            $category = "category_{$key}";

            $$category = (new Category)
                ->setLevel($value['level'])
                ->setParameter($value['param'])
                ->setTitle($value['title']);

            $manager->persist($$category);
        }

        $manager->flush();

        foreach($data as $key => $value)
        {
            $category = "category_{$key}";

            $this->addReference($category, $$category);
        }
    }

    public function getOrder()
    {
        return 1;
    }
}