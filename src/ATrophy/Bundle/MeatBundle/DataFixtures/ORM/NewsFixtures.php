<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/NewsFixtures.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM;

use ATrophy\Entity\Meat\News;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

class NewsFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $news = new News;
        $news->setImageOriginal("1.jpg")
            ->setImageThumb("1.jpg")
            ->setTitle("Кубок Независимости – 2014")
            ->setText('<div id="line-1" class="line">30-31 августа 2014 г. в Шахматном центре «Товарищ» прошел «Кубок Независимости – 2014» по быстрым шахматам и молниеносной игре.</div><div id="line-3" class="line"><br></div><div id="line-5" class="line">Турнир собрал большое количество любителей и профессионалов шахмат. Благодаря президенту Киевской Федерации шахмат Павлу Вячеславовичу Куфтыреву учредили призовой фонд в 5000 грн.</div><div id="line-7" class="line"><br></div><div id="line-9" class="line">Участники были награждены наградами, произведенными компанией A-Trophy. </div><div id="line-11" class="line"><br></div><div id="line-13" class="line">Поздравляем победителей! Желаем новых побед и достижений.</div>')
            ->setVisible(TRUE);
        $manager->persist($news);

        $manager->flush();
    }
}