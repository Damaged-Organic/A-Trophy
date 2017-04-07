<?php
// ATrophy/Entity/Translation/IntroItemTranslation.php
namespace ATrophy\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @ORM\Table(name="intro_item_translations", indexes={
 *      @ORM\Index(name="intro_item_translations_idx", columns={"locale", "field"})
 * })
 */
class IntroItemTranslation extends AbstractTranslation
{

}
