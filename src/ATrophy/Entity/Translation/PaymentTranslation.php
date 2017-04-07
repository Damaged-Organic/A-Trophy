<?php
// ATrophy/Entity/Translation/PaymentTranslation.php
namespace ATrophy\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @ORM\Table(name="payments_translations", indexes={
 *      @ORM\Index(name="payments_translations_idx", columns={"locale", "field"})
 * })
 */
class PaymentTranslation extends AbstractTranslation
{

}
