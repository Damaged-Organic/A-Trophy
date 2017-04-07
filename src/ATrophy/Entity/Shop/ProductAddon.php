<?php
// ATrophy/Entity/Shop/ProductAddon.php
namespace ATrophy\Entity\Shop;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ATrophy\Entity\Repository\Shop\ProductAddonRepository")
 * @ORM\Table(name="shop_products_addons")
 */
class ProductAddon
{
    const STATUETTE = 'statuette';
    const TOKEN     = 'token';
    const TOPTOKEN  = 'toptoken';
    const RIBBON    = 'ribbon';
    const BOX       = 'box';
    const PLATE     = 'plate';
    const ETCHING   = 'etching';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $hasStatuette;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $hasToken;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $hasTopToken;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $hasEtching;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $hasPlate;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $hasRibbon;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $hasBox;

    //---

    /**
     * @ORM\OneToOne(targetEntity="Product", inversedBy="productAddon")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;

    /**
     * Check if addon available based on method name - dirty:
     * have to rewrite ajax parameters in case of properties renaming
     *
     * @param $addon
     * @return bool
     */
    public function checkAddonAvailbility($addon)
    {
        $method = "getHas{$addon}";

        if( !method_exists($this, $method) ) {
            return FALSE;
        }

        return ( $this->{$method}() ) ? TRUE : FALSE;
    }

    /**
     * Does product have any addons?
     *
     * @return bool
     */
    public function hasAnyAddons()
    {
        return $this->hasStatuette ||
            $this->hasToken ||
            $this->hasTopToken ||
            $this->hasEtching ||
            $this->hasPlate ||
            $this->hasRibbon ||
            $this->hasBox;
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
     * Set hasStatuette
     *
     * @param boolean $hasStatuette
     * @return ProductAddon
     */
    public function setHasStatuette($hasStatuette)
    {
        $this->hasStatuette = $hasStatuette;

        return $this;
    }

    /**
     * Get hasStatuette
     *
     * @return boolean 
     */
    public function getHasStatuette()
    {
        return $this->hasStatuette;
    }

    /**
     * Set hasToken
     *
     * @param boolean $hasToken
     * @return ProductAddon
     */
    public function setHasToken($hasToken)
    {
        $this->hasToken = $hasToken;

        return $this;
    }

    /**
     * Get hasToken
     *
     * @return boolean 
     */
    public function getHasToken()
    {
        return $this->hasToken;
    }

    /**
     * Set hasTopToken
     *
     * @param boolean $hasTopToken
     * @return ProductAddon
     */
    public function setHasTopToken($hasTopToken)
    {
        $this->hasTopToken = $hasTopToken;

        return $this;
    }

    /**
     * Get hasTopToken
     *
     * @return boolean 
     */
    public function getHasTopToken()
    {
        return $this->hasTopToken;
    }

    /**
     * Set hasEtching
     *
     * @param boolean $hasEtching
     * @return ProductAddon
     */
    public function setHasEtching($hasEtching)
    {
        $this->hasEtching = $hasEtching;

        return $this;
    }

    /**
     * Get hasEtching
     *
     * @return boolean 
     */
    public function getHasEtching()
    {
        return $this->hasEtching;
    }

    /**
     * Set hasPlate
     *
     * @param boolean $hasPlate
     * @return ProductAddon
     */
    public function setHasPlate($hasPlate)
    {
        $this->hasPlate = $hasPlate;

        return $this;
    }

    /**
     * Get hasPlate
     *
     * @return boolean 
     */
    public function getHasPlate()
    {
        return $this->hasPlate;
    }

    /**
     * Set hasRibbon
     *
     * @param boolean $hasRibbon
     * @return ProductAddon
     */
    public function setHasRibbon($hasRibbon)
    {
        $this->hasRibbon = $hasRibbon;

        return $this;
    }

    /**
     * Get hasRibbon
     *
     * @return boolean 
     */
    public function getHasRibbon()
    {
        return $this->hasRibbon;
    }

    /**
     * Set hasBox
     *
     * @param boolean $hasBox
     * @return ProductAddon
     */
    public function setHasBox($hasBox)
    {
        $this->hasBox = $hasBox;

        return $this;
    }

    /**
     * Get hasBox
     *
     * @return boolean 
     */
    public function getHasBox()
    {
        return $this->hasBox;
    }

    /**
     * Set product
     *
     * @param \ATrophy\Entity\Shop\Product $product
     * @return ProductAddon
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
}
