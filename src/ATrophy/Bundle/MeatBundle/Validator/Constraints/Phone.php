<?php
// ATrophy/Bundle/MeatBundle/Validator/Constraints/Phone.php
namespace ATrophy\Bundle\MeatBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Phone extends Constraint
{
    public $message = "Некорректный формат номера телефона";

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}