<?php
// ATrophy/Entity/Shop/Token.php
namespace ATrophy\Entity\Shop;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="ATrophy\Entity\Repository\Shop\TokenRepository")
 * @ORM\Table(name="shop_tokens")
 *
 * @Gedmo\TranslationEntity(class="ATrophy\Entity\Translation\Shop\TokenTranslation")
 */
class Token
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
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Gedmo\Translatable
     */
    protected $color;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    protected $diameter;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    protected $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, nullable=true)
     */
    protected $image;

    //---

    /**
     * @ORM\ManyToOne(targetEntity="Thematic", inversedBy="token")
     * @ORM\JoinColumn(name="thematic_id", referencedColumnName="id")
     */
    protected $thematic;

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
     * @return Token
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
     * Set color
     *
     * @param string $color
     * @return Token
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
     * Set diameter
     *
     * @param string $diameter
     * @return Token
     */
    public function setDiameter($diameter)
    {
        $this->diameter = $diameter;

        return $this;
    }

    /**
     * Get diameter
     *
     * @return string 
     */
    public function getDiameter()
    {
        return $this->diameter;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Token
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
     * Set thematic
     *
     * @param \ATrophy\Entity\Shop\Thematic $thematic
     * @return Token
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
     * Set image
     *
     * @param string $image
     * @return Token
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
}
