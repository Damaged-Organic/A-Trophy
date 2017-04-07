<?php
//src/ATrophy/Service/CRUD/CRUDAddon.php
namespace ATrophy\Service\CRUD;

use ATrophy\Entity\Shop\Token,
    ATrophy\Entity\Shop\Ribbon,
    ATrophy\Entity\Shop\Box;

class CRUDAddon
{
    public function combineToken(array $token)
    {
        $token = array_merge([
            'title'    => '',
            'diameter' => NULL,
            'price'    => NULL,
            'image'    => ''
        ], $token);

        $token['price']    = ( $token['price'] ) ? $token['price'] : NULL;
        $token['diameter'] = ( $token['diameter'] ) ? $token['diameter'] : NULL;

        return $token;
    }

    public function combineRibbon(array $ribbon)
    {
        $ribbon = array_merge([
            'title' => '',
            'width' => NULL,
            'price' => NULL,
            'image' => ''
        ], $ribbon);

        $ribbon['price'] = ( $ribbon['price'] ) ? $ribbon['price'] : NULL;
        $ribbon['width'] = ( $ribbon['width'] ) ? $ribbon['width'] : NULL;

        return $ribbon;
    }

    public function combineBox(array $box)
    {
        $box = array_merge([
            'title' => '',
            'size'  => NULL,
            'price' => NULL,
            'image' => ''
        ], $box);

        $box['price'] = ( $box['price'] ) ? $box['price'] : NULL;
        $box['size']  = ( $box['size'] ) ? $box['size'] : NULL;

        return $box;
    }

    public function combineAddon($addonType, $addon)
    {
        switch( $addonType )
        {
            case 'token':
                $addon = $this->combineToken($addon);
            break;

            case 'ribbon':
                $addon = $this->combineRibbon($addon);
            break;

            case 'box':
                $addon = $this->combineBox($addon);
            break;

            default:
                return [];
            break;
        }

        return $addon;
    }

    public function setAddons($addonType, $addons, $data)
    {
        foreach($addons as $addon)
        {
            $addonId = $addon->getId();

            $addon->setTitle($data[$addonId]['title'])
                ->setPrice($data[$addonId]['price'])
                ->setImage($data[$addonId]['image']);

            switch( $addonType )
            {
                case 'token':
                    $addon->setDiameter($data[$addonId]['diameter']);
                break;

                case 'ribbon':
                    $addon->setWidth($data[$addonId]['width']);
                break;

                case 'box':
                    $addon->setSize($data[$addonId]['size']);
                break;
            }
        }

        return $addons;
    }

    public function setAddonImage($addon, $image)
    {
        $addon->setImage($image);

        return $addon;
    }

    public function addAddon($addonType, $data)
    {
        switch( $addonType )
        {
            case 'token':
                $addon = (new Token)
                    ->setDiameter($data['diameter']);
            break;

            case 'ribbon':
                $addon = (new Ribbon)
                    ->setWidth($data['width']);
            break;

            case 'box':
                $addon = (new Box)
                    ->setSize($data['size']);
            break;

            default:
                return FALSE;
            break;
        }

        $addon->setTitle($data['title'])
            ->setPrice($data['price'])
            ->setImage($data['image']);

        return $addon;
    }
}