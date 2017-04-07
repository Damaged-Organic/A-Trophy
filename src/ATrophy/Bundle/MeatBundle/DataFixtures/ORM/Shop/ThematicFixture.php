<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/Shop/ThematicFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM\Shop;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use ATrophy\Entity\Shop\Thematic;

class ThematicFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = [
            ['title' => "Автомобильный спорт"],
            ['title' => "Армреслинг"],
            ['title' => "Бадминтон"],
            ['title' => "Бакалавр"],
            ['title' => "Баскетбол"],
            ['title' => "Бег и легкая атлетика"],
            ['title' => "Бильярд"],
            ['title' => "Бодибилдинг"],
            ['title' => "Бокс"],
            ['title' => "Борьба"],
            ['title' => "Боулинг"],
            ['title' => "Велоспорт"],
            ['title' => "Водное поло"],
            ['title' => "Воллейбол"],
            ['title' => "Гандбол"],
            ['title' => "Гимнастика"],
            ['title' => "Гиревый спорт"],
            ['title' => "Голубь"],
            ['title' => "Гольф"],
            ['title' => "Дартс"],
            ['title' => "Дзюдо"],
            ['title' => "Домино"],
            ['title' => "Звезды (коллекция)"],
            ['title' => "Зимние виды"],
            ['title' => "Инвалид"],
            ['title' => "Карате"],
            ['title' => "Карты"],
            ['title' => "Кикбоксинг"],
            ['title' => "Конный спорт"],
            ['title' => "Королева красоты"],
            ['title' => "Мотоспорт"],
            ['title' => "Музыка"],
            ['title' => "Нейтральные"],
            ['title' => "Национальная символика"],
            ['title' => "Ника"],
            ['title' => "Оскар"],
            ['title' => "Пауэрлифтинг и тяжелая атлетика"],
            ['title' => "Плавание"],
            ['title' => "Пожарники"],
            ['title' => "Рыбалка"],
            ['title' => "Собаки"],
            ['title' => "Стрельба"],
            ['title' => "Танцы"],
            ['title' => "Театр"],
            ['title' => "Теннис"],
            ['title' => "Фигурное катание"],
            ['title' => "Футбол"],
            ['title' => "Хоккей"],
            ['title' => "Шахматы"],
            ['title' => "Яхты"]
        ];

        foreach($data as $key => $value)
        {
            $thematic = "thematic_{$key}";

            $$thematic = (new Thematic)
                ->setTitle($value['title']);
            $manager->persist($$thematic);
        }

        $manager->flush();

        foreach($data as $key => $value)
        {
            $thematic = "thematic_{$key}";

            $this->addReference($thematic, $$thematic);
        }
    }

    public function getOrder()
    {
        return 1;
    }
}