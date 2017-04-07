<?php
// ATrophy/Entity/Common/Directory.php
namespace ATrophy\Entity\Common;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as GEDMO,
    Gedmo\Translatable\Translatable;

/**
 * @ORM\Entity(repositoryClass="ATrophy\Entity\Repository\DirectoryRepository")
 * @ORM\Table(name="directories")
 *
 * @GEDMO\TranslationEntity(class="ATrophy\Entity\Translation\DirectoryTranslation")
 */
class Directory implements Translatable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
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
    protected $route;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @GEDMO\Translatable
     */
    protected $title;

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
     * @return Directory
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
     * Set route
     *
     * @param string $route
     * @return Directory
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string 
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Directory
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
}
