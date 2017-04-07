<?php
// ATrophy/Entity/Shop/Product.php
namespace ATrophy\Entity\Shop;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="ATrophy\Entity\Repository\Shop\ProductRepository")
 * @ORM\Table(name="shop_products")
 *
 * @Gedmo\TranslationEntity(class="ATrophy\Entity\Translation\Shop\ProductTranslation")
 */
class Product
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
    protected $created;

    /**
     * @ORM\Column(type="bigint")
     */
    protected $updated;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * //@Gedmo\Translatable
     */
    protected $title;

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

    /**
     * @ORM\Column(type="integer")
     */
    protected $ratingVotes;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    protected $ratingScore;

    /**
     * @ORM\Column(type="integer")
     */
    protected $views;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isVisible;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    protected $currentPrice;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    protected $kitPrice;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * //@Gedmo\Translatable
     */
    protected $imprint;

    //---

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="productCategory")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="productSubcategory")
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id")
     */
    protected $subcategory;

    /**
     * @ORM\ManyToOne(targetEntity="Thematic", inversedBy="product")
     * @ORM\JoinColumn(name="thematic_id", referencedColumnName="id")
     */
    protected $thematic;

    //---

    /**
     * @ORM\OneToMany(targetEntity="ProductItem", mappedBy="product", cascade={"persist", "remove"})
     */
    protected $productItem;

    /**
     * @ORM\OneToOne(targetEntity="ProductAddon", mappedBy="product", cascade={"persist", "remove"})
     */
    protected $productAddon;

    /**
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * Set translatable locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    public function makeImprint($title)
    {
        $imprint = trim(preg_replace('#[^\\pL\d]+#u', '_', $title), '-_');

        $imprint = mb_strtolower($imprint, 'utf-8');

        if( empty($imprint) ) {
            return 'без_названия';
        }

        return $imprint;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $time = time();

        $this->setCreated($time);
        $this->setUpdated($time);
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
     * @return Product
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
     * Set updated
     *
     * @param integer $updated
     * @return Product
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return integer
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        $this->setImprint($title);

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * Set ratingVotes
     *
     * @param integer $ratingVotes
     * @return Product
     */
    public function setRatingVotes($ratingVotes)
    {
        $this->ratingVotes = $ratingVotes;

        return $this;
    }

    /**
     * Get ratingVotes
     *
     * @return integer
     */
    public function getRatingVotes()
    {
        return $this->ratingVotes;
    }

    /**
     * Set ratingScore
     *
     * @param string $ratingScore
     * @return Product
     */
    public function setRatingScore($ratingScore)
    {
        $this->ratingScore = $ratingScore;

        return $this;
    }

    /**
     * Get ratingScore
     *
     * @return string
     */
    public function getRatingScore()
    {
        return $this->ratingScore;
    }

    /**
     * Set views
     *
     * @param integer $views
     * @return Product
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set isVisible
     *
     * @param boolean $isVisible
     * @return Product
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * Get isVisible
     *
     * @return boolean
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }

    /**
     * Set currentPrice
     *
     * @param string $currentPrice
     * @return Product
     */
    public function setCurrentPrice($currentPrice)
    {
        $this->currentPrice = $currentPrice;

        return $this;
    }

    /**
     * Get currentPrice
     *
     * @return string
     */
    public function getCurrentPrice()
    {
        return $this->currentPrice;
    }

    /**
     * Set kitPrice
     *
     * @param string $currentPrice
     * @return Product
     */
    public function setKitPrice($kitPrice)
    {
        $this->kitPrice = $kitPrice;

        return $this;
    }

    /**
     * Get kitPrice
     *
     * @return string
     */
    public function getKitPrice()
    {
        return $this->kitPrice;
    }

    /**
     * Set imprint
     *
     * @param string $imprint
     * @return Product
     */
    public function setImprint($title)
    {
        $this->imprint = $this->makeImprint($title);

        return $this;
    }

    /**
     * Get imprint
     *
     * @return string
     */
    public function getImprint()
    {
        return $this->imprint;
    }

    /**
     * Set category
     *
     * @param \ATrophy\Entity\Shop\Category $category
     * @return Product
     */
    public function setCategory(\ATrophy\Entity\Shop\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \ATrophy\Entity\Shop\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set subcategory
     *
     * @param \ATrophy\Entity\Shop\Category $subcategory
     * @return Product
     */
    public function setSubcategory(\ATrophy\Entity\Shop\Category $subcategory = null)
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    /**
     * Get subcategory
     *
     * @return \ATrophy\Entity\Shop\Category
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set thematic
     *
     * @param \ATrophy\Entity\Shop\Thematic $thematic
     * @return Product
     */
    public function setThematic(\ATrophy\Entity\Shop\Thematic $thematic = null)
    {
        $this->thematic = $thematic;

        return $this;
    }

    /**
     * Get thematic
     *
     * @return \ATrophy\Entity\Shop\Thematic
     */
    public function getThematic()
    {
        return $this->thematic;
    }

    /**
     * Add productItem
     *
     * @param \ATrophy\Entity\Shop\ProductItem $productItem
     * @return Product
     */
    public function addProductItem(\ATrophy\Entity\Shop\ProductItem $productItem)
    {
        $this->productItem[] = $productItem;

        return $this;
    }

    /**
     * Remove productItem
     *
     * @param \ATrophy\Entity\Shop\ProductItem $productItem
     */
    public function removeProductItem(\ATrophy\Entity\Shop\ProductItem $productItem)
    {
        $this->productItem->removeElement($productItem);
    }

    /**
     * Get productItem
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductItem()
    {
        return $this->productItem;
    }

    /**
     * Set productAddon
     *
     * @param \ATrophy\Entity\Shop\ProductAddon $productAddon
     * @return Product
     */
    public function setProductAddon(\ATrophy\Entity\Shop\ProductAddon $productAddon = null)
    {
        $this->productAddon = $productAddon;

        return $this;
    }

    /**
     * Get productAddon
     *
     * @return \ATrophy\Entity\Shop\ProductAddon
     */
    public function getProductAddon()
    {
        return $this->productAddon;
    }
}
