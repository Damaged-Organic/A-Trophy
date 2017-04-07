<?php
// ATrophy/Entity/Translation/Shop/BoxTranslation.php
namespace ATrophy\Entity\Translation\Shop;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @ORM\Table(name="shop_boxes_translations", indexes={
 *      @ORM\Index(name="shop_boxes_translations_idx", columns={"locale", "field"})
 * })
 */
class BoxTranslation extends AbstractTranslation
{

}
