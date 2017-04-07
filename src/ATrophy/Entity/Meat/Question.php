<?php
// ATrophy/Entity/Meat/Question.php
namespace ATrophy\Entity\Meat;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="ATrophy\Entity\Repository\QuestionRepository")
 * @ORM\Table(name="questions")
 *
 * @Gedmo\TranslationEntity(class="ATrophy\Entity\Translation\QuestionTranslation")
 */
class Question
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
     * @ORM\Column(type="bigint")
     */
    protected $created;

    /**
     * @ORM\Column(type="bigint")
     */
    protected $updated;

    /**
     * @ORM\Column(type="text")
     *
     * @Gedmo\Translatable
     */
    protected $question;

    /**
     * @ORM\Column(type="text")
     *
     * @Gedmo\Translatable
     */
    protected $answer;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $visible;

    public function __construct()
    {
        $time = time();

        $this->setCreated($time);
        $this->setUpdated($time);
    }

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
     * Set created
     *
     * @param integer $created
     * @return Question
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
     * Set updated
     *
     * @param integer $updated
     * @return Question
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return integer 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set question
     *
     * @param string $question
     * @return Question
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set answer
     *
     * @param string $answer
     * @return Question
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     * @return Question
     */
    public function setVisible($visible)
    {
        if( !is_bool($visible) ) {
            throw new \InvalidArgumentException("Argument should be of type boolean");
        }

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
}
