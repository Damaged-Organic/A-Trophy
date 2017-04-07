<?php
// ATrophy/Entity/Common/Contact.php
namespace ATrophy\Entity\Common;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ATrophy\Entity\Repository\ContactRepository")
 * @ORM\Table(name="contacts")
 */
class Contact
{
    const TYPE_ADDRESS = 'address';
    const TYPE_PHONE   = 'phone';
    const TYPE_EMAIL   = 'email';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('address', 'phone', 'email')")
     */
    protected $type;

    /**
     * @ORM\Column(type="string")
     */
    protected $credential;

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
     * Set type
     *
     * @param string $type
     * @return Contact
     */
    public function setType($type)
    {
        $types = [self::TYPE_ADDRESS, self::TYPE_EMAIL, self::TYPE_PHONE];

        if( !in_array($type, $types, TRUE) ) {
            throw new \InvalidArgumentException("Invalid type");
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set credential
     *
     * @param string $credential
     * @return Contact
     */
    public function setCredential($credential)
    {
        $this->credential = $credential;

        return $this;
    }

    /**
     * Get credential
     *
     * @return string 
     */
    public function getCredential()
    {
        return $this->credential;
    }
}
