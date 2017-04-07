<?php
// ATrophy/Entity/Translation/Shop/CategoryTranslation.php
namespace ATrophy\Entity\Translation\Shop;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @ORM\Table(name="shop_categories_translations", indexes={
 *      @ORM\Index(name="shop_categories_translations_idx", columns={"locale", "field"})
 * })
 */
class CategoryTranslation extends AbstractTranslation
{

}
