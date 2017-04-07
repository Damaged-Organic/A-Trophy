<?php
// ATrophy/Entity/Meat/Client.php
namespace ATrophy\Entity\Meat;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="ATrophy\Entity\Repository\ClientRepository")
 * @ORM\Table(name="clients")
 *
 * @Gedmo\TranslationEntity(class="ATrophy\Entity\Translation\ClientTranslation")
 */
class Client
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
     *
     * @Gedmo\Translatable
     */
    protected $name;

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
     * @return Client
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
     * Set name
     *
     * @param string $name
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Client
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
