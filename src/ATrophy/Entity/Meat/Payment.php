<?php
// ATrophy/Entity/Meat/Payment.php
namespace ATrophy\Entity\Meat;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="ATrophy\Entity\Repository\PaymentRepository")
 * @ORM\Table(name="payments")
 *
 * @Gedmo\TranslationEntity(class="ATrophy\Entity\Translation\PaymentTranslation")
 */
class Payment
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
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Gedmo\Translatable
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     *
     * @Gedmo\Translatable
     */
    protected $text;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $image;

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
     * Set rowOrder
     *
     * @param integer $rowOrder
     * @return Payment
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
     * Set title
     *
     * @param string $title
     * @return Payment
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
     * Set text
     *
     * @param string $text
     * @return Payment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Payment
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
