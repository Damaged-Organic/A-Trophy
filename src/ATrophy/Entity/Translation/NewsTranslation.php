<?php
// ATrophy/Entity/Translation/NewsTranslation.php
namespace ATrophy\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @ORM\Table(name="news_translations", indexes={
 *      @ORM\Index(name="news_translations_idx", columns={"locale", "field"})
 * })
 */
class NewsTranslation extends AbstractTranslation
{

}
