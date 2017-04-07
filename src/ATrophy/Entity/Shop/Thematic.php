<?php
// ATrophy/Entity/Shop/Thematic.php
namespace ATrophy\Entity\Shop;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="ATrophy\Entity\Repository\Shop\ThematicRepository")
 * @ORM\Table(name="shop_thematics")
 *
 * @Gedmo\TranslationEntity(class="ATrophy\Entity\Translation\Shop\ThematicTranslation")
 */
class Thematic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Gedmo\Translatable
     */
    protected $title;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="thematic")
     */
    protected $product;

    /**
     * @ORM\OneToMany(targetEntity="Token", mappedBy="thematic")
     */
    protected $token;

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
     * Set title
     *
     * @param string $title
     * @return Thematic
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
     * Constructor
     */
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
        $this->token = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add product
     *
     * @param \ATrophy\Entity\Shop\Product $product
     * @return Thematic
     */
    public function addProduct(\ATrophy\Entity\Shop\Product $product)
    {
        $this->product[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \ATrophy\Entity\Shop\Product $product
     */
    public function removeProduct(\ATrophy\Entity\Shop\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Add token
     *
     * @param \ATrophy\Entity\Shop\Token $token
     * @return Thematic
     */
    public function addToken(\ATrophy\Entity\Shop\Token $token)
    {
        $this->token[] = $token;

        return $this;
    }

    /**
     * Remove token
     *
     * @param \ATrophy\Entity\Shop\Token $token
     */
    public function removeToken(\ATrophy\Entity\Shop\Token $token)
    {
        $this->token->removeElement($token);
    }

    /**
     * Get token
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getToken()
    {
        return $this->token;
    }
}
