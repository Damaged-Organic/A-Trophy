<?php
// ATrophy/Bundle/MeatBundle/Validator/Constraints/PhoneValidator.php
namespace ATrophy\Bundle\MeatBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint,
    Symfony\Component\Validator\ConstraintValidator;

class PhoneValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if( !empty($value) )
        {
            if (!preg_match('/^\+380\s\([0-9]{2}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/', $value, $matches)) {
                $this->context->addViolation(
                    $constraint->message,
                    ['%string%' => $value]
                );
            }
        }
    }
}