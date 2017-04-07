<?php
// ATrophy/Entity/Meat/Deliverer.php
namespace ATrophy\Entity\Meat;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ATrophy\Entity\Repository\DelivererRepository")
 * @ORM\Table(name="deliverers")
 */
class Deliverer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $rowOrder;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

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
     * Set rowOrder
     *
     * @param integer $rowOrder
     * @return Deliverer
     */
    public function setRowOrder($rowOrder)
    {
        $this->rowOrder = $rowOrder;

        return $this;
    }

    /**
     * Get rowOrder
     *
     * @return integer 
     */
    public function getRowOrder()
    {
        return $this->rowOrder;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Deliverer
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Deliverer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}
