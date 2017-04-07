<?php
// src/ATrophy/Service/Order.php
namespace ATrophy\Service;

use Doctrine\ORM\EntityManager;

use Symfony\Component\HttpFoundation\Session\Session,
    Symfony\Bundle\TwigBundle\TwigEngine;

class Order
{
    private $_manager;
    private $_session;

    private $_cart;
    private $_shopPageData;
    private $_fileUpload;
    private $_mailer;

    private $emails;

    public function __construct(EntityManager $manager, Session $session, TwigEngine $templating, Cart $cart, ShopPageData $shopPageData, FileUpload $fileUpload, $mailer, $email_noReply, $email_office, $email_personal, $email_company)
    {
        $this->_manager    = $manager;
        $this->_session    = $session;
        $this->_templating = $templating;

        $this->_cart         = $cart;
        $this->_shopPageData = $shopPageData;
        $this->_fileUpload   = $fileUpload;
        $this->_mailer       = $mailer;

        $this->emails = [
            'noReply'  => $email_noReply,
            'office'   => $email_office,
            'personal' => $email_personal,
            'company'  => $email_company
        ];
    }

    public function processOrder($order)
    {
        if( !($cartItems = $this->getCartItems()) ) {
            return ['error' => 'В вашей корзине пусто. Возможно, вы долгое время не предпринимали никаких действий, и система решила, что вы ушли'];
        }

        $transformLambda = function($input_array) {
            $output_array = [];

            foreach($input_array as $value) {
                $output_array[] = $value['orderId'];
            }

            return $output_array;
        };

        $existingOrderIds = $transformLambda($this->getExistingOrderIds());

        $orderId = $this->generateOrderId($existingOrderIds);

        if( !($lastOrderId = $this->saveOrder($order, $cartItems, $orderId)) ) {
            return ['error' => 'При обработке заказа возникла проблема. Приносим извинения за неудобства, попробуйте сделать заказ еще раз'];
        }

        if( !($orderData = $this->getOrderData($lastOrderId) ) ) {
            return ['error' => 'При обработке заказа возникла проблема. Приносим извинения за неудобства, попробуйте сделать заказ еще раз'];
        }

        $orderData['orderItems'] = $this->_fileUpload->transferTmpImages($orderData['order']->getOrderId(), $orderData['orderItems']);

        $this->updateOrder($orderData['order'], $orderData['orderItems']);

        if( !$this->sendOrderMessages(
            $orderData['order'],
            $orderData['orderItems'],
            $orderData['orderProducts']) ) {
            return ['error' => 'Ошибка при формировании заказа. Приносим извинения за неудобства, попробуйте сделать заказ еще раз'];
        } else {
            return ['orderId' => $orderData['order']->getOrderId()];
        }
    }

    private function getCartItems()
    {
        return $this->_cart->getCart();
    }

    private function getExistingOrderIds()
    {
        return $this->_manager
            ->getRepository('ATrophy\Entity\Order\Order')
            ->findOrderIds();
    }

    private function generateOrderId($existingOrderIds)
    {
        $orderId = rand(1000000, 9999999);

        while( in_array($orderId, $existingOrderIds) ) {
            $orderId = rand(1000000, 9999999);
        }

        return $orderId;
    }

    private function saveOrder($order, $cartItems, $orderId)
    {
        $order->setItems(json_encode($cartItems));
        $order->setOrderId($orderId);

        $this->_manager->persist($order);

        $this->_manager->flush();

        return $order->getId();
    }

    private function updateOrder($order, $orderItems)
    {
        $order->setItems(json_encode($orderItems));

        $this->_manager->persist($order);

        $this->_manager->flush();
    }

    private function getOrderData($lastOrderId)
    {
        $order = $this->_manager->getRepository('ATrophy\Entity\Order\Order')->find($lastOrderId);

        $orderItems = json_decode($order->getItems(), TRUE);

        $ids = $this->_cart->getCartProductsIds($orderItems);

        $orderProducts = $this->_shopPageData->getProductsByIds($ids);

        return [
            'order'         => $order,
            'orderItems'    => $orderItems,
            'orderProducts' => $orderProducts
        ];
    }

    private function sendOrderMessages($order, $orderItems, $orderProducts)
    {
        $messageAdmin = \Swift_Message::newInstance()

            ->setSubject("Клиент сделал заказ! (#" . $order->getOrderId() . ")")
            ->setFrom([
                $this->emails['noReply'] => "Интернет-магазин A-Trophy"]
            )
            ->setTo([
                $this->emails['office'],
                $this->emails['personal'],
                $this->emails['company']
            ])
            ->setBody(
                $this->_templating->render('ATrophyMeatBundle:Email:order.html.twig', [
                    'addressee'     => 'ADMIN',
                    'order'         => $order,
                    'orderItems'    => $orderItems,
                    'orderProducts' => $orderProducts
                ]),
                'text/html'
            );

        $messageUser = \Swift_Message::newInstance()
            ->setSubject("Вы сделали заказ! (#" . $order->getOrderId() . ")")
            ->setFrom(
                [$this->emails['noReply'] => "Интернет-магазин A-Trophy"]
            )
            ->setTo(
                $order->getClientEmail()
            )
            ->setBody(
                $this->_templating->render('ATrophyMeatBundle:Email:order.html.twig', [
                    'addressee'     => 'USER',
                    'order'         => $order,
                    'orderItems'    => $orderItems,
                    'orderProducts' => $orderProducts
                ]),
                'text/html'
            );

        return ( $this->_mailer->send($messageAdmin) && $this->_mailer->send($messageUser) ) ? TRUE : FALSE;
    }
}