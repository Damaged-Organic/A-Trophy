<?php
// ATrophy/Entity/Translation/QuestionTranslation.php
namespace ATrophy\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @ORM\Table(name="questions_translations", indexes={
 *      @ORM\Index(name="questions_translations_idx", columns={"locale", "field"})
 * })
 */
class QuestionTranslation extends AbstractTranslation
{

}
