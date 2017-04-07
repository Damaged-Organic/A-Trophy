<?php
// ATrophy/Entity/Translation/ClientTranslation.php
namespace ATrophy\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @ORM\Table(name="clients_translations", indexes={
 *      @ORM\Index(name="clients_translations_idx", columns={"locale", "field"})
 * })
 */
class ClientTranslation extends AbstractTranslation
{

}
