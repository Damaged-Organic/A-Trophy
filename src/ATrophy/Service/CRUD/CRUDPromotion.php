<?php
//src/ATrophy/Service/CRUD/CRUDPromotion.php
namespace ATrophy\Service\CRUD;

use ATrophy\Entity\Meat\Promotion;

class CRUDPromotion
{
    public function setPromotion($imageName)
    {
        $promotion = (new Promotion)
            ->setImage($imageName);

        return $promotion;
    }
}