<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/RegionFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM;

use ATrophy\Entity\Meat\Region;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

class RegionFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
		$data = [
			[
				'title' => "АР Крым",
				'image' => "crimea.jpg"
			],
			[
				'title' => "Винницкая",
				'image' => "vinnytsa.jpg"
			],
			[
				'title' => "Волынская",
				'image' => "volyn.jpg"
			],
			[
				'title' => "Днепропетровская",
				'image' => "dnipropetrovsk.jpg"
			],
			[
				'title' => "Донецкая",
				'image' => "donetsk.jpg"
			],
			[
				'title' => "Ивано-Франковская",
				'image' => "ivano-frankovsk.jpg"
			],
			[
				'title' => "Житомирская",
				'image' => "zytomyr.jpg"
			],
			[
				'title' => "Закарпатская",
				'image' => "karpaty.jpg"
			],
			[
				'title' => "Запорожская",
				'image' => "zaporozie.jpg"
			],
			[
				'title' => "Кировоградская",
				'image' => "kirovograd.jpg"
			],
			[
				'title' => "Киевская",
				'image' => "kyiv-oblast.jpg"
			],
			[
				'title' => "Луганская",
				'image' => "luhansk.jpg"
			],
			[
				'title' => "Львовская",
				'image' => "lviv.jpg"
			],
			[
				'title' => "Николаевская",
				'image' => "nikolaev.jpg"
			],
			[
				'title' => "Одесская",
				'image' => "odessa.jpg"
			],
			[
				'title' => "Полтавская",
				'image' => "poltava.jpg"
			],
			[
				'title' => "Ровенская",
				'image' => "rivne.jpg"
			],
			[
				'title' => "Сумская",
				'image' => "symu.jpg"
			],
			[
				'title' => "Тернопольская",
				'image' => "ternopil.jpg"
			],
			[
				'title' => "Харьковская",
				'image' => "kharkiv.jpg"
			],
			[
				'title' => "Херсонская",
				'image' => "kherson.jpg"
			],
			[
				'title' => "Хмельницкая",
				'image' => "khmelnytskyi.jpg"
			],
			[
				'title' => "Черкасская",
				'image' => "cherkassy.jpg"
			],
			[
				'title' => "Черниговская",
				'image' => "chernihiv.jpg"
			],
			[
				'title' => "Черновицкая",
				'image' => "chernivtsi.jpg"
			]
		];
		
		foreach($data as $value)
		{
			$region = (new Region)
				->setTitle($value['title'])
				->setImage($value['image']);
			$manager->persist($region);
		}
		
		$manager->flush();
	}
}