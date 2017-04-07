<?php
// ATrophy/Entity/Translation/Shop/ThematicTranslation.php
namespace ATrophy\Entity\Translation\Shop;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @ORM\Table(name="shop_thematics_translations", indexes={
 *      @ORM\Index(name="shop_thematics_translations_idx", columns={"locale", "field"})
 * })
 */
class ThematicTranslation extends AbstractTranslation
{

}
