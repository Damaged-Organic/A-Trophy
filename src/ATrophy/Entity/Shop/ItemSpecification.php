<?php
// ATrophy/Entity/Shop/ItemSpecification.php
namespace ATrophy\Entity\Shop;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="ATrophy\Entity\Repository\Shop\ItemSpecificationRepository")
 * @ORM\Table(name="shop_items_specifications")
 *
 * @Gedmo\TranslationEntity(class="ATrophy\Entity\Translation\Shop\ItemSpecificationTranslation")
 */
class ItemSpecification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * //@Gedmo\Translatable
     */
    protected $color;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * //@Gedmo\Translatable
     */
    protected $colorTouch;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    protected $height;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    protected $diameterGoblet;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    protected $diameterMedal;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    protected $diameterToken;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    protected $stand;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    protected $holder;

    //---

    /**
     * @ORM\OneToOne(targetEntity="ProductItem", inversedBy="itemSpecification")
     * @ORM\JoinColumn(name="product_item_id", referencedColumnName="id")
     */
    protected $productItem;

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

    public function getFormattedProperties()
    {
        return array_filter([
            'color'          => $this->getColor(),
            'colorTouch'     => $this->getColorTouch(),
            'height'         => $this->getHeight(),
            'diameterGoblet' => $this->getDiameterGoblet(),
            'diameterMedal'  => $this->getDiameterMedal()
        ]);
    }

    /**
     * Is specification empty?
     *
     * @return bool
     */
    public function isSpecificationEmpty()
    {
        return $this->color ||
            $this->colorTouch ||
            $this->height ||
            $this->diameterGoblet ||
            $this->diameterMedal ||
            $this->diameterToken;
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
     * Set color
     *
     * @param string $color
     * @return ItemSpecification
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set colorTouch
     *
     * @param string $colorTouch
     * @return ItemSpecification
     */
    public function setColorTouch($colorTouch)
    {
        $this->colorTouch = $colorTouch;

        return $this;
    }

    /**
     * Get colorTouch
     *
     * @return string
     */
    public function getColorTouch()
    {
        return $this->colorTouch;
    }

    /**
     * Set height
     *
     * @param string $height
     * @return ItemSpecification
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set diameterGoblet
     *
     * @param string $diameterGoblet
     * @return ItemSpecification
     */
    public function setDiameterGoblet($diameterGoblet)
    {
        $this->diameterGoblet = $diameterGoblet;

        return $this;
    }

    /**
     * Get diameterGoblet
     *
     * @return string
     */
    public function getDiameterGoblet()
    {
        return $this->diameterGoblet;
    }

    /**
     * Set diameterMedal
     *
     * @param string $diameterMedal
     * @return ItemSpecification
     */
    public function setDiameterMedal($diameterMedal)
    {
        $this->diameterMedal = $diameterMedal;

        return $this;
    }

    /**
     * Get diameterMedal
     *
     * @return string
     */
    public function getDiameterMedal()
    {
        return $this->diameterMedal;
    }

    /**
     * Set diameterToken
     *
     * @param string $diameterToken
     * @return ItemSpecification
     */
    public function setDiameterToken($diameterToken)
    {
        $this->diameterToken = $diameterToken;

        return $this;
    }

    /**
     * Get diameterToken
     *
     * @return string
     */
    public function getDiameterToken()
    {
        return $this->diameterToken;
    }

    /**
     * Set stand
     *
     * @param string $stand
     * @return ItemSpecification
     */
    public function setStand($stand)
    {
        $this->stand = $stand;

        return $this;
    }

    /**
     * Get stand
     *
     * @return string
     */
    public function getStand()
    {
        return $this->stand;
    }

    /**
     * Set holder
     *
     * @param string $holder
     * @return ItemSpecification
     */
    public function setHolder($holder)
    {
        $this->holder = $holder;

        return $this;
    }

    /**
     * Get holder
     *
     * @return string
     */
    public function getHolder()
    {
        return $this->holder;
    }

    /**
     * Set productItem
     *
     * @param \ATrophy\Entity\Shop\ProductItem $productItem
     * @return ItemSpecification
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
