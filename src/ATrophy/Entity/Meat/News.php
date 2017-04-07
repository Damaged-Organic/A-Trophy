<?php
// ATrophy/Entity/Meat/News.php
namespace ATrophy\Entity\Meat;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="ATrophy\Entity\Repository\NewsRepository")
 * @ORM\Table(name="news")
 *
 * @Gedmo\TranslationEntity(class="ATrophy\Entity\Translation\NewsTranslation")
 */
class News
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
    protected $created;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $imageOriginal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $imageThumb;

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
     *
     * @Gedmo\Translatable
     */
    protected $imprint;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $visible;

    public function __construct()
    {
        $this->setCreated(time());
    }

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
     * @return News
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
     * Set imageOriginal
     *
     * @param string $imageOriginal
     * @return News
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
     * Set imageThumb
     *
     * @param string $imageThumb
     * @return News
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
     * Set title
     *
     * @param string $title
     * @return News
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
     * Set text
     *
     * @param string $text
     * @return News
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
     * Set visible
     *
     * @param boolean $visible
     * @return News
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set imprint
     *
     * @param string $imprint
     * @return News
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
}
