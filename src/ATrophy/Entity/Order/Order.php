<?php
// src/ATrophy/Entity/Order/Order.php
namespace ATrophy\Entity\Order;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ATrophy\Entity\Repository\Order\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    protected $id;

    /**
     * @ORM\Column(type="bigint")
     */
    protected $orderId;

    /**
     * @ORM\Column(type="bigint")
     */
    protected $created;

    /**
     * @ORM\Column(type="text")
     */
    protected $items;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $clientName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $clientEmail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $clientPhone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $deliveryType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $deliveryRegion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $deliveryCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $deliveryAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $deliveryService;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $serviceOffice;

    public function __construct()
    {
        $this->created = time();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param integer $created
     * @return Order
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return integer 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set items
     *
     * @param string $items
     * @return Order
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Get items
     *
     * @return string 
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set clientName
     *
     * @param string $clientName
     * @return Order
     */
    public function setClientName($clientName)
    {
        $this->clientName = $clientName;

        return $this;
    }

    /**
     * Get clientName
     *
     * @return string 
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * Set clientEmail
     *
     * @param string $clientEmail
     * @return Order
     */
    public function setClientEmail($clientEmail)
    {
        $this->clientEmail = $clientEmail;

        return $this;
    }

    /**
     * Get clientEmail
     *
     * @return string 
     */
    public function getClientEmail()
    {
        return $this->clientEmail;
    }

    /**
     * Set clientPhone
     *
     * @param string $clientPhone
     * @return Order
     */
    public function setClientPhone($clientPhone)
    {
        $this->clientPhone = $clientPhone;

        return $this;
    }

    /**
     * Get clientPhone
     *
     * @return string 
     */
    public function getClientPhone()
    {
        return $this->clientPhone;
    }

    /**
     * Set deliveryType
     *
     * @param string $deliveryType
     * @return Order
     */
    public function setDeliveryType($deliveryType)
    {
        $this->deliveryType = $deliveryType;

        return $this;
    }

    /**
     * Get deliveryType
     *
     * @return string 
     */
    public function getDeliveryType()
    {
        return $this->deliveryType;
    }

    /**
     * Set deliveryRegion
     *
     * @param string $deliveryRegion
     * @return Order
     */
    public function setDeliveryRegion($deliveryRegion)
    {
        $this->deliveryRegion = $deliveryRegion;

        return $this;
    }

    /**
     * Get deliveryRegion
     *
     * @return string 
     */
    public function getDeliveryRegion()
    {
        return $this->deliveryRegion;
    }

    /**
     * Set deliveryCity
     *
     * @param string $deliveryCity
     * @return Order
     */
    public function setDeliveryCity($deliveryCity)
    {
        $this->deliveryCity = $deliveryCity;

        return $this;
    }

    /**
     * Get deliveryCity
     *
     * @return string 
     */
    public function getDeliveryCity()
    {
        return $this->deliveryCity;
    }

    /**
     * Set deliveryAddress
     *
     * @param string $deliveryAddress
     * @return Order
     */
    public function setDeliveryAddress($deliveryAddress)
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    /**
     * Get deliveryAddress
     *
     * @return string 
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    /**
     * Set deliveryService
     *
     * @param string $deliveryService
     * @return Order
     */
    public function setDeliveryService($deliveryService)
    {
        $this->deliveryService = $deliveryService;

        return $this;
    }

    /**
     * Get deliveryService
     *
     * @return string 
     */
    public function getDeliveryService()
    {
        return $this->deliveryService;
    }

    /**
     * Set serviceOffice
     *
     * @param string $serviceOffice
     * @return Order
     */
    public function setServiceOffice($serviceOffice)
    {
        $this->serviceOffice = $serviceOffice;

        return $this;
    }

    /**
     * Get serviceOffice
     *
     * @return string 
     */
    public function getServiceOffice()
    {
        return $this->serviceOffice;
    }

    /**
     * Set orderId
     *
     * @param integer $orderId
     * @return Order
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return integer 
     */
    public function getOrderId()
    {
        return $this->orderId;
    }
}
