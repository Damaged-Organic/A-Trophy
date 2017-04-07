<?php
// ATrophy/Bundle/MeatBundle/DataFixtures/ORM/PaymentFixture.php
namespace ATrophy\Bundle\MeatBundle\DataFixtures\ORM;

use ATrophy\Entity\Meat\Payment;

use Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

class PaymentFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $payment = (new Payment)
            ->setRowOrder(1)
            ->setImage("payment-1.jpg")
            ->setTitle("Наличная")
            ->setText("Наличная оплата возможна только при покупке товара в Киеве и Днепропетровске, а также в отделениях Новой Почты по Украине. Оплата производится исключительно в национальной валюте. В подтверждение оплаты мы выдаем вам товарный чек");
        $manager->persist($payment);

        $payment = (new Payment)
            ->setRowOrder(2)
            ->setImage("payment-2.jpg")
            ->setTitle("Безналичная")
            ->setText("Оплата по безналичному расчету осуществляется следующим образом: после оформления заказа менеджер электронной почтой вышлет счет-фактуру, который вы сможете оплатить в кассе отделения любого банка или с расчетного счета вашей компании. Для юридических лиц пакет всех необходимых документов предоставляется вместе с товаром");
        $manager->persist($payment);

        $payment = (new Payment)
            ->setRowOrder(3)
            ->setImage("payment-3.jpg")
            ->setTitle("Платежные карты Visa и MasterCard")
            ->setText("Вы можете оплатить заказ online любой картой Visa или MasterCard любого банка без комиссии не выходя из дома или офиса. Оплата происходит через систему безопасных платежей Приват Банка. После оплаты просьба сообщить менеджеру о переводе денег и отправить ксерокопию чека на e-mail нашей компании");
        $manager->persist($payment);

        $payment = (new Payment)
            ->setRowOrder(4)
            ->setImage("payment-4.jpg")
            ->setTitle("Наложенный платеж")
            ->setText("Вы можете оплатить товар в любом отделении Новой Почты в случае оформления наложенного платежа. При этом у вас будет возможность осмотреть товар на соответствие. В случае ошибки нашей компании, мы повторно бесплатно отправляем заказ");
        $manager->persist($payment);

        $manager->flush();
    }
}