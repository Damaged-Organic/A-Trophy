<?php
// src/ATrophy/Service/InventoryPageData.php
namespace ATrophy\Service;

use Doctrine\ORM\EntityManager;

use Symfony\Component\HttpFoundation\Session\Session;

use ATrophy\Entity\Shop\ItemSpecification,
    ATrophy\Entity\Shop\ProductAddon;

class InventoryPageData
{
    const BUNDLE = 'ATrophy\Entity\Shop';

    const CUSTOM_TOKEN_PRICE_25 = '0.90';
    const CUSTOM_TOKEN_PRICE_50 = '2.50';

    const ETCHING_PRICE         = '1.50';

    const PLATE_PRICE           = '5.00';

    private $_manager;
    private $_session;
    private $_dataTransform;
    private $_fileUpload;

    private $_securityContext;

    public function __construct(EntityManager $manager, Session $session, DataTransform $dataTransform, FileUpload $fileUpload, $securityContext)
    {
        $this->_manager       = $manager;
        $this->_session       = $session;
        $this->_dataTransform = $dataTransform;
        $this->_fileUpload    = $fileUpload;

        $this->_securityContext = $securityContext;
    }

    /* Statuette */

    public function getStatuettes($itemSpecifications)
    {
        $products = $this->_manager
            ->getRepository(self::BUNDLE . '\Product')
            ->findStatuettes($this->_securityContext->isGranted('ROLE_ADMIN'));

        return $this->transformStatuette($products);
    }

    private function transformStatuette($products)
    {
        $imageLambda = function($object) {
            return $object->getImageSquare();
        };

        $transformLambda = function($input_object) use($imageLambda)
        {
            $output_array = [];

            foreach($input_object as $product)
            {
                foreach($product->getProductItem() as $item)
                {
                    $productId = $product->getId();
                    $itemId    = $item->getId();
                    $images    = $item->getItemImage()->map($imageLambda)->toArray();

                    $standLessPrice = ( $item->getItemSpecification() ) ? $item->getItemSpecification()->getStand() : NULL;
                    $normalPrice    = ( $item->getPricePromo() ) ? $item->getPricePromo() : $item->getPrice();

                    $output_array[] = [
                        'id'     => $itemId,
                        'title'  => $product->getTitle(),
                        'height' => ( $item->getItemSpecification() ) ? $item->getItemSpecification()->getHeight() : NULL,
                        'image'  => ( !empty($images[0]) ) ? "{$productId}/{$images[0]}" : "{$productId}/" . $product->getImageSquare(),
                        'price'  => ( $standLessPrice ) ?: $normalPrice
                    ];
                }
            }

            return $output_array;
        };

        return ( $products ) ? $this->_dataTransform->transform($products, $transformLambda) : NULL;
    }

    public function getStatuettesBlocks($itemSpecifications)
    {
        $items = $this->getStatuettes($itemSpecifications);

        if( !$items )
            return FALSE;

        return [
            'tabs' => [
                'Выбрать статуэтку'
            ],
            'products' => [
                'type'  => ProductAddon::STATUETTE,
                'items' => $items,
                'path'  => "bundles/atrophymeat/images/store/products/"
            ],
            'etchings' => [
                'type'  => NULL,
                'text'  => FALSE,
                'image' => FALSE
            ]
        ];
    }

    public function getStatuetteData($addonItemId)
    {
        $statuette = $this->_manager
            ->getRepository(self::BUNDLE . '\Product')
            ->findStatuette($addonItemId, $this->_securityContext->isGranted('ROLE_ADMIN'));

        $statuette = $this->transformStatuette($statuette)[0];

        return [
            'name'  => "Установить статуэтку на крышку",
            'image' => "bundles/atrophymeat/images/store/products/{$statuette['image']}",
            'price' => $statuette['price'],
            'data'  => [
                'type'  => ProductAddon::STATUETTE,
                'id'    => $statuette['id'],
                'title' => $statuette['title']
            ]
        ];
    }

    /* Token */

    public function getTokens(ItemSpecification $itemSpecifications)
    {
        if( $itemSpecifications->getDiameterToken() ) {
            $diameter = $itemSpecifications->getDiameterToken();
        } elseif(
            $itemSpecifications->getDiameterMedal() ) {
            $diameter = $itemSpecifications->getDiameterMedal();
        } else {
            return FALSE;
        }

        return $this->_manager
            ->getRepository(self::BUNDLE . '\Token')
            ->findByDiameter($diameter);
    }

    public function getTopTokensBlocks($itemSpecifications)
    {
        $items = $this->getTokens($itemSpecifications);

        if( !$items )
            return FALSE;

        $transform = function($items) use($itemSpecifications) {
            foreach($items as $item) {
                $item->setPrice($item->getPrice() + $itemSpecifications->getHolder());
            }

            return $items;
        };

        return [
            'tabs' => [
                'Выбрать жетон', 'Загрузить собственный жетон'
            ],
            'products' => [
                'type'  => ProductAddon::TOPTOKEN,
                'items' => $transform($items),
                'path'  => 'bundles/atrophymeat/images/store/addons/tokens/'
            ],
            'etchings' => [
                'type'  => ProductAddon::TOPTOKEN,
                'text'  => TRUE,
                'image' => TRUE
            ]
        ];
    }

    public function getTopTokenData($addonItem)
    {
        $item = $this->_manager
            ->getRepository(self::BUNDLE . '\Token')
            ->find($addonItem['itemId']);

        //Hotfix
        $tokenPrice = $item->getPrice();

        if( !empty($addonItem['itemSpecifications']) )
        {
            if( $addonItem['itemSpecifications']->getHolder() ) {
                $tokenPrice = $item->getPrice() + $addonItem['itemSpecifications']->getHolder();
            }
        }

        return [
            'name'  => "Установить жетон с держателем",
            'image' => "bundles/atrophymeat/images/store/addons/tokens/" . $item->getImage(),
            'price' => $tokenPrice,
            'data'  => [
                'type'  => ProductAddon::TOPTOKEN,
                'id'    => $item->getId(),
                'title' => $item->getTitle()
            ]
        ];
    }

    public function getCustomTopTokenData($etching)
    {
        $imageName = NULL;
        $customTokenPrice = self::CUSTOM_TOKEN_PRICE_25;

        if( $etching['image'] )
        {
            $imageName = $etching['image']->getClientOriginalName();

            if( !($etching['image'] = $this->handleImage($etching['image'])) ) {
                return FALSE;
            }
        }

        //Hotfix
        if( !empty($etching['itemSpecifications']) )
        {
            if( $etching['itemSpecifications']->getDiameterToken() ) {
                $diameter = $etching['itemSpecifications']->getDiameterToken();
            } elseif(
                $etching['itemSpecifications']->getDiameterMedal() ) {
                $diameter = $etching['itemSpecifications']->getDiameterMedal();
            } else {
                $diameter = NULL;
            }

            if( $diameter == 25 ) {
                $customTokenPrice = self::CUSTOM_TOKEN_PRICE_25;
            } elseif( $diameter == 50 ) {
                $customTokenPrice = self::CUSTOM_TOKEN_PRICE_50;
            }

            if( $etching['itemSpecifications']->getHolder() ) {
                $customTokenPrice += $etching['itemSpecifications']->getHolder();
            }
        }
        //END\Hotfix

        return [
            'name'  => "Установить жетон с держателем",
            'image' => "bundles/atrophymeat/images/inventory/topToken_active.png",
            'price' => $customTokenPrice,
            'data'  => [
                'type'      => ProductAddon::TOPTOKEN,
                'text'      => $etching['text'],
                'image'     => $etching['image'],
                'imageName' => $imageName
            ]
        ];
    }

    public function getTokensBlocks($itemSpecifications)
    {
        $items = $this->getTokens($itemSpecifications);

        if( !$items )
            return FALSE;

        return [
            'tabs' => [
                'Выбрать жетон', 'Загрузить собственный жетон'
            ],
            'products' => [
                'type'  => ProductAddon::TOKEN,
                'items' => $items,
                'path'  => 'bundles/atrophymeat/images/store/addons/tokens/'
            ],
            'etchings' => [
                'type'  => ProductAddon::TOKEN,
                'text'  => TRUE,
                'image' => TRUE
            ]
        ];
    }

    public function getTokenData($addonItemId)
    {
        $item = $this->_manager
            ->getRepository(self::BUNDLE . '\Token')
            ->find($addonItemId);

        return [
            'name'  => "Добавить жетон",
            'image' => "bundles/atrophymeat/images/store/addons/tokens/" . $item->getImage(),
            'price' => $item->getPrice(),
            'data'  => [
                'type'  => ProductAddon::TOKEN,
                'id'    => $item->getId(),
                'title' => $item->getTitle()
            ]
        ];
    }

    public function getCustomTokenData($etching)
    {
        $imageName = NULL;
        $customTokenPrice = self::CUSTOM_TOKEN_PRICE_25;

        if( $etching['image'] )
        {
            $imageName = $etching['image']->getClientOriginalName();

            if( !($etching['image'] = $this->handleImage($etching['image'])) ) {
                return FALSE;
            }
        }

        //Hotfix
        if( !empty($etching['itemSpecifications']) )
        {
            if( $etching['itemSpecifications']->getDiameterToken() ) {
                $diameter = $etching['itemSpecifications']->getDiameterToken();
            } elseif(
            $etching['itemSpecifications']->getDiameterMedal() ) {
                $diameter = $etching['itemSpecifications']->getDiameterMedal();
            } else {
                $diameter = NULL;
            }

            if( $diameter == 25 ) {
                $customTokenPrice = self::CUSTOM_TOKEN_PRICE_25;
            } elseif( $diameter == 50 ) {
                $customTokenPrice = self::CUSTOM_TOKEN_PRICE_50;
            }
        }
        //END\Hotfix

        return [
            'name'  => "Добавить жетон",
            'image' => "bundles/atrophymeat/images/inventory/bottomToken_active.png",
            'price' => $customTokenPrice,
            'data'  => [
                'type'      => ProductAddon::TOKEN,
                'text'      => $etching['text'],
                'image'     => $etching['image'],
                'imageName' => $imageName
            ]
        ];
    }

    /* Ribbon */

	public function getRibbons(ItemSpecification $itemSpecifications)
	{
        if( ($diameterMedal = (int)$itemSpecifications->getDiameterMedal()) == 0 ) {
            return $this->_manager
                ->getRepository(self::BUNDLE . '\Ribbon')
                ->findAll();
        }

        if( ($diameterMedal > 0) && ($diameterMedal <= 50) ) {
            $width = 10;
        } elseif( ($diameterMedal > 50) && ($diameterMedal <= 100) ) {
            $width = 20;
        }

        return $this->_manager
            ->getRepository(self::BUNDLE . '\Ribbon')
            ->findByWidth($width);
	}

    public function getRibbonsBlocks($itemSpecifications)
    {
        $items = $this->getRibbons($itemSpecifications);

        if( !$items )
            return FALSE;

        return [
            'tabs' => [
                'Выбрать ленту'
            ],
            'products' => [
                'type'  => ProductAddon::RIBBON,
                'items' => $items,
                'path'  => 'bundles/atrophymeat/images/store/addons/ribbons/'
            ],
            'etchings' => [
                'type'  => NULL,
                'text'  => FALSE,
                'image' => FALSE
            ]
        ];
    }

    public function getRibbonData($addonItemId)
    {
        $item = $this->_manager
            ->getRepository(self::BUNDLE . '\Ribbon')
            ->find($addonItemId);

        return [
            'name'  => "Добавить ленту",
            'image' => "bundles/atrophymeat/images/store/addons/ribbons/" . $item->getImage(),
            'price' => $item->getPrice(),
            'data'  => [
                'type'  => ProductAddon::RIBBON,
                'id'    => $item->getId(),
                'title' => $item->getTitle()
            ]
        ];
    }

    /* Box */

	public function getBoxes(ItemSpecification $itemSpecifications)
	{
        if( ($diameterMedal = (int)$itemSpecifications->getDiameterMedal()) == 0 ) {
            return $this->_manager
                ->getRepository(self::BUNDLE . '\Box')
                ->findAll();
        }

        if( ($diameterMedal > 0) && ($diameterMedal <= 50) ) {
            $minSize = 0;
            $maxSize = 50;
        } elseif( ($diameterMedal > 50) && ($diameterMedal <= 100) ) {
            $minSize = 50;
            $maxSize = 100;
        } else {
            return $this->_manager
                ->getRepository(self::BUNDLE . '\Box')
                ->findAll();
        }

        return $this->_manager
            ->getRepository(self::BUNDLE . '\Box')
            ->findFitBySize($minSize, $maxSize);
	}

    public function getBoxesBlocks($itemSpecifications)
    {
        $items = $this->getBoxes($itemSpecifications);

        if( !$items )
            return FALSE;

        return [
            'tabs' => [
                'Выбрать коробку под медаль'
            ],
            'products' => [
                'type'  => ProductAddon::BOX,
                'items' => $items,
                'path'  => 'bundles/atrophymeat/images/store/addons/boxes/'
            ],
            'etchings' => [
                'type'  => NULL,
                'text'  => FALSE,
                'image' => FALSE
            ]
        ];
    }

    public function getBoxData($addonItemId)
    {
        $item = $this->_manager
            ->getRepository(self::BUNDLE . '\Box')
            ->find($addonItemId);

        return [
            'name'  => "Коробка под медаль",
            'image' => "bundles/atrophymeat/images/store/addons/boxes/" . $item->getImage(),
            'price' => $item->getPrice(),
            'data'  => [
                'type'  => ProductAddon::BOX,
                'id'    => $item->getId(),
                'title' => $item->getTitle()
            ]
        ];
    }

    /* Plate */

    public function getPlateBlocks()
    {
        return [
            'tabs' => [
                'Нанести гравировку на шильдик'
            ],
            'products' => NULL,
            'etchings' => [
                'type'  => ProductAddon::PLATE,
                'text'  => TRUE,
                'image' => FALSE
            ]
        ];
    }

    public function getPlateData($etching)
    {
        return [
            'name'  => "Добавить шильдик",
            'image' => "bundles/atrophymeat/images/inventory/plate_active.png",
            'price' => self::PLATE_PRICE,
            'data'  => [
                'type'  => ProductAddon::PLATE,
                'text'  => $etching['text'],
                'image' => NULL
            ]
        ];
    }

    /* Etching */

    public function getEtchingBlocks()
    {
        return [
            'tabs' => [
                'Нанести гравировку'
            ],
            'products' => NULL,
            'etchings' => [
                'type'  => ProductAddon::ETCHING,
                'text'  => TRUE,
                'image' => TRUE
            ]
        ];
    }

    public function getEtchingData($etching)
    {
        $imageName = NULL;

        if( $etching['image'] )
        {
            $imageName = $etching['image']->getClientOriginalName();

            if( !($etching['image'] = $this->handleImage($etching['image'])) ) {
                return FALSE;
            }
        }

        return [
            'name'  => "Нанести гравировку",
            'image' => "bundles/atrophymeat/images/inventory/awardText_active.png",
            'price' => self::ETCHING_PRICE,
            'data'  => [
                'type'      => ProductAddon::ETCHING,
                'text'      => $etching['text'],
                'image'     => $etching['image'],
                'imageName' => $imageName
            ]
        ];
    }

    /* Storage */

    public function saveAddonData($productId, $addonType, $addonData)
    {
        if( $this->_session->has('addons') ) {
            $addons = $this->_session->get('addons');
        } else {
            $addons = [];
        }

        $addons[$productId][$addonType] = $addonData;

        $this->_session->set('addons', $addons);

        return $addons;
    }

    public function obtainAddonData($productId)
    {
        if( $this->_session->has('addons') ) {
            $addons = $this->_session->get('addons');
        } else {
            $addons = [];
        }
		
        return ( !empty($addons[$productId]) ) ? $addons[$productId] : [];
    }

    public function selectSavedAddon($productId, $addonType)
    {
        if( !$this->_session->has('addons') ) {
            return FALSE;
        } else {
            $addons = $this->_session->get('addons');
        }

        return ( !empty($addons[$productId][$addonType]) ) ? $addons[$productId][$addonType] : FALSE;
    }

    public function unsetSavedAddon($productId, $addonType)
    {
        if( !$this->_session->has('addons') ) {
            return FALSE;
        } else {
            $addons = $this->_session->get('addons');
        }

        $product = $addons[$productId];
        unset($product[$addonType]);
        $addons[$productId] = $product;

        $this->_session->set('addons', $addons);

        return $addons;
    }

    public function countAddonsTotalPrice($productId, $addons)
    {
        $price = 0.00;

        if( empty($addons[$productId]) ) return 0.00;

        foreach($addons[$productId] as $item) {
            $price += $item['price'];
        }

        return $price;
    }

    public function countSingleAddonsTotalPrice($addons)
    {
        $price = 0.00;

        foreach($addons as $item) {
            $price += $item['price'];
        }

        return $price;
    }

    public function handleImage($image)
    {
        $this->_session->start();

        $link = [
            'folder'    => "tmp/pre_order",
            'tmpFolder' => $this->_session->getId(),
            'fileName'  => time()
        ];

        if( !($uploadedFileName = $this->_fileUpload->saveUploadedFile($image, $link['folder'], $link['tmpFolder'], $link['fileName'])) ) {
            return FALSE;
        } else {
            return "tmp/pre_order/{$uploadedFileName}";
        }
    }
}