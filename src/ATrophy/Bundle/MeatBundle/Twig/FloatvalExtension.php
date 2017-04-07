<?php
// src/ATrophy/Bundle/MeatBundle/Twig/FloatvalExtension.php
namespace ATrophy\Bundle\MeatBundle\Twig;

class FloatvalExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('floatval', array($this, 'floatvalFilter')),
        );
    }

    public function floatvalFilter($input)
    {
        return ( is_numeric($input) ) ? floatval($input) : $input;
    }

    public function getName()
    {
        return 'floatval_extension';
    }
}