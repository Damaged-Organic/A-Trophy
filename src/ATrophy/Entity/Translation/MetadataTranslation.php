<?php
// ATrophy/Entity/Translation/MetadataTranslation.php
namespace ATrophy\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @ORM\Table(name="metadata_translations", indexes={
 *      @ORM\Index(name="metadata_translations_idx", columns={"locale", "field"})
 * })
 */
class MetadataTranslation extends AbstractTranslation
{

}
