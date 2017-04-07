<?php
// ATrophy/Entity/Translation/DirectoryTranslation.php
namespace ATrophy\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @ORM\Table(name="directory_translations", indexes={
 *      @ORM\Index(name="directory_translations_idx", columns={"locale", "field"})
 * })
 */
class DirectoryTranslation extends AbstractTranslation
{

}
