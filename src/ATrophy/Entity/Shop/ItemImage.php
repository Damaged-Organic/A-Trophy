<?php
// ATrophy/Entity/Shop/ItemImage.php
namespace ATrophy\Entity\Shop;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ATrophy\Entity\Repository\Shop\ItemImageRepository")
 * @ORM\Table(name="shop_items_images")
 */
class ItemImage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $imageSquare;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $imageThumb;

    //---

    /**
     * @ORM\ManyToOne(targetEntity="ProductItem", inversedBy="itemImage")
     * @ORM\JoinColumn(name="product_item_id", referencedColumnName="id")
     */
    protected $productItem;

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
     * Set image
     *
     * @param string $image
     * @return ItemImage
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
     * Set imageSquare
     *
     * @param string $imageSquare
     * @return ItemImage
     */
    public function setImageSquare($imageSquare)
    {
        $this->imageSquare = $imageSquare;

        return $this;
    }

    /**
     * Get imageSquare
     *
     * @return string
     */
    public function getImageSquare()
    {
        return $this->imageSquare;
    }

    /**
     * Set imageThumb
     *
     * @param string $imageThumb
     * @return ItemImage
     */
    public function setImageThumb($imageThumb)
    {
        $this->imageThumb = $imageThumb;

        return $this;
    }

    /**
     * Get imageThumb
     *
     * @return string 
     */
    public function getImageThumb()
    {
        return $this->imageThumb;
    }

    /**
     * Set productItem
     *
     * @param \ATrophy\Entity\Shop\ProductItem $productItem
     * @return ItemImage
     */
    public function setProductItem(\ATrophy\Entity\Shop\ProductItem $productItem = null)
    {
        $this->productItem = $productItem;

        return $this;
    }

    /**
     * Get productItem
     *
     * @return \ATrophy\Entity\Shop\ProductItem 
     */
    public function getProductItem()
    {
        return $this->productItem;
    }
}
