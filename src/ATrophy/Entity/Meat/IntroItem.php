<?php
// ATrophy/Entity/Meat/IntroItem.php:2
namespace ATrophy\Entity\Meat;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="ATrophy\Entity\Repository\IntroItemRepository")
 * @ORM\Table(name="intro_items")
 *
 * @Gedmo\TranslationEntity(class="ATrophy\Entity\Translation\IntroItemTranslation")
 */
class IntroItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    protected $id;

    /**
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * @ORM\Column(type="integer")
     */
    protected $rowOrder;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $categorySubdirectory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $imageOriginal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $imageFiltered;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Gedmo\Translatable
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=TRUE)
     *
     * @Gedmo\Translatable
     */
    protected $text;

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
     * @return IntroItem
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
     * Set categorySubdirectory
     *
     * @param string $categorySubdirectory
     * @return IntroItem
     */
    public function setCategorySubdirectory($categorySubdirectory)
    {
        $this->categorySubdirectory = $categorySubdirectory;

        return $this;
    }

    /**
     * Get categorySubdirectory
     *
     * @return string 
     */
    public function getCategorySubdirectory()
    {
        return $this->categorySubdirectory;
    }

    /**
     * Set imageOriginal
     *
     * @param string $imageOriginal
     * @return IntroItem
     */
    public function setImageOriginal($imageOriginal)
    {
        $this->imageOriginal = $imageOriginal;

        return $this;
    }

    /**
     * Get imageOriginal
     *
     * @return string 
     */
    public function getImageOriginal()
    {
        return $this->imageOriginal;
    }

    /**
     * Set imageFiltered
     *
     * @param string $imageFiltered
     * @return IntroItem
     */
    public function setImageFiltered($imageFiltered)
    {
        $this->imageFiltered = $imageFiltered;

        return $this;
    }

    /**
     * Get imageFiltered
     *
     * @return string 
     */
    public function getImageFiltered()
    {
        return $this->imageFiltered;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return IntroItem
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
     * @return IntroItem
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
}
