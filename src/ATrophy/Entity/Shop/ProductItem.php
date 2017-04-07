<?php
// ATrophy/Entity/Shop/ProductItem.php
namespace ATrophy\Entity\Shop;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ATrophy\Entity\Repository\Shop\ProductItemRepository")
 * @ORM\Table(name="shop_products_items")
 */
class ProductItem
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
    protected $article;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    protected $price;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    protected $pricePromo;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $stock;

    //---

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productItem")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;

    //---

    /**
     * @ORM\OneToMany(targetEntity="ItemImage", mappedBy="productItem", cascade={"persist", "remove"})
     */
    protected $itemImage;

    /**
     * @ORM\OneToOne(targetEntity="ItemSpecification", mappedBy="productItem", cascade={"persist", "remove"})
     */
    protected $itemSpecification;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->itemImage = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set article
     *
     * @param string $article
     * @return ProductItem
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return string 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return ProductItem
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set pricePromo
     *
     * @param string $pricePromo
     * @return ProductItem
     */
    public function setPricePromo($pricePromo)
    {
        $this->pricePromo = $pricePromo;

        return $this;
    }

    /**
     * Get pricePromo
     *
     * @return string 
     */
    public function getPricePromo()
    {
        return $this->pricePromo;
    }

    /**
     * Set stock
     *
     * @param boolean $stock
     * @return ProductItem
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return boolean 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set product
     *
     * @param \ATrophy\Entity\Shop\Product $product
     * @return ProductItem
     */
    public function setProduct(\ATrophy\Entity\Shop\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \ATrophy\Entity\Shop\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Add itemImage
     *
     * @param \ATrophy\Entity\Shop\ItemImage $itemImage
     * @return ProductItem
     */
    public function addItemImage(\ATrophy\Entity\Shop\ItemImage $itemImage)
    {
        $this->itemImage[] = $itemImage;

        return $this;
    }

    /**
     * Remove itemImage
     *
     * @param \ATrophy\Entity\Shop\ItemImage $itemImage
     */
    public function removeItemImage(\ATrophy\Entity\Shop\ItemImage $itemImage)
    {
        $this->itemImage->removeElement($itemImage);
    }

    /**
     * Get itemImage
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItemImage()
    {
        return $this->itemImage;
    }

    /**
     * Set itemSpecification
     *
     * @param \ATrophy\Entity\Shop\ItemSpecification $itemSpecification
     * @return ProductItem
     */
    public function setItemSpecification(\ATrophy\Entity\Shop\ItemSpecification $itemSpecification = null)
    {
        $this->itemSpecification = $itemSpecification;

        return $this;
    }

    /**
     * Get itemSpecification
     *
     * @return \ATrophy\Entity\Shop\ItemSpecification 
     */
    public function getItemSpecification()
    {
        return $this->itemSpecification;
    }
}
