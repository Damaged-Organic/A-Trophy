<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/QuestionFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM;

use ATrophy\Entity\Meat\Question;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

class QuestionFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $question = (new Question)
            ->setQuestion("Возможно ли посмотреть продукцию вживую?")
            ->setAnswer("Да, вы можете ознакомиться со всей продукцией в нашем выстовочном зале по адресу: г. Киев, ул. Васильковская, 14 (м. \"Голосеевская\")")
            ->setVisible(TRUE);
        $manager->persist($question);

        $question = (new Question)
            ->setQuestion("Можно ли нанести логотип на жетон или табличку?")
            ->setAnswer("На жетон и табличку можно нанести любое изображение в цвете, логотип или текст")
            ->setVisible(TRUE);
        $manager->persist($question);

        $question = (new Question)
            ->setQuestion("В каком количестве присутствует продукция? Если мне необходимо 1000 медалей, будет ли такое количество на складе?")
            ->setAnswer("Товары из основного каталога присутствуют в количестве более 10 000 шт., и доставляются в течение 1-2 дней. Наличие акционных товаров лучше уточнять у менеджера")
            ->setVisible(TRUE);
        $manager->persist($question);

        $manager->flush();
    }
}