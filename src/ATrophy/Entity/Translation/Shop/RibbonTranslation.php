<?php
// ATrophy/Entity/Translation/Shop/RibbonTranslation.php
namespace ATrophy\Entity\Translation\Shop;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @ORM\Table(name="shop_ribbons_translations", indexes={
 *      @ORM\Index(name="shop_ribbons_translations_idx", columns={"locale", "field"})
 * })
 */
class RibbonTranslation extends AbstractTranslation
{

}
