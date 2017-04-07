<?php
// ATrophy/Bundle/MeatBundle/Form/Type/TelType.php
namespace ATrophy\Bundle\MeatBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

class TelType extends AbstractType
{
    public function getName()
    {
        return 'tel';
    }

    public function getParent()
    {
        return 'text';
    }
}