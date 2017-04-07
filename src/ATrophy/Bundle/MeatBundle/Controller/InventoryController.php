<?php
// src/ATrophy/Bundle/MeatBundle/Controller/InventoryController.php
namespace ATrophy\Bundle\MeatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

use ATrophy\Entity\Shop\Product,
    ATrophy\Entity\Shop\ProductAddon;

class InventoryController extends Controller
{
    private function getError($message = NULL)
    {
        if( !$message ) {
            $message = "Вы не ввели нужные данные. Попробуйте еще раз после закрытия всплывающего окна";
        }

        return new Response("
            <p class='darkGray inventoryError'>{$message}</p>
            <span class='orange counter'>5</span>
        ", 500);
    }

    private function getErrorPlain($message = NULL)
    {
        if( !$message ) {
            $message = "Произошла ошибка при обработке запроса";
        }

        return new Response(
            "<p class='darkGray'>{$message}</p>",
            500
        );
    }

    /* Select addons */

    public function selectAction(Request $request)
    {
        if( !$request->request->get('productId') ||
            !$request->request->get('type') ) {
            return $this->getError();
        } else {
            $productId = $request->request->get('productId');
            $addonType = $request->request->get('type');
        }

        $_shopPageData = $this->get('atrophy.shop_page_data');

        $product = $_shopPageData->getProduct($productId);

        if( !$product ) {
            return $this->getError();
        } else {
            $product = $product[0];
        }

        if( !$product->getProductAddon()->checkAddonAvailbility($addonType) ) {
            return $this->getErrorPlain();
        }

        $itemSpecifications = $this->getItemSpecifications($product);

        if( !($popupBlocks = $this->getPopupBlocks($addonType, $itemSpecifications)) ) {
            return $this->getError("К сожалению, эти дополнения в данный момент отсутствуют в каталоге");
        }

        if( !($addonView = $this->getAddonView($productId, $popupBlocks, $addonType)) ) {
            return $this->getErrorPlain();
        }

        return new Response(json_encode($addonView), 200);
    }

    private function getItemSpecifications(Product $product)
    {
        $lambda = function($object) {
            return $object->getItemSpecification();
        };

        $itemSpecifications = $product->getProductItem()
            ->map($lambda)
            ->toArray();

        return $itemSpecifications[0];
    }

    private function getPopupBlocks($addonType, $itemSpecifications)
    {
        $_inventoryPageData = $this->get('atrophy.inventory_page_data');

        $popupBlocks = [];

        switch($addonType)
        {
            case ProductAddon::STATUETTE:
                $popupBlocks = $_inventoryPageData->getStatuettesBlocks($itemSpecifications);
            break;

            case ProductAddon::TOPTOKEN:
                $popupBlocks = $_inventoryPageData->getTopTokensBlocks($itemSpecifications);
            break;

            case ProductAddon::TOKEN:
                $popupBlocks = $_inventoryPageData->getTokensBlocks($itemSpecifications);
            break;

            case ProductAddon::RIBBON:
                $popupBlocks = $_inventoryPageData->getRibbonsBlocks($itemSpecifications);
            break;

            case ProductAddon::BOX:
                $popupBlocks = $_inventoryPageData->getBoxesBlocks($itemSpecifications);
            break;

            case ProductAddon::PLATE:
                $popupBlocks = $_inventoryPageData->getPlateBlocks();
            break;

            case ProductAddon::ETCHING:
                $popupBlocks = $_inventoryPageData->getEtchingBlocks();
            break;
        }

        return $popupBlocks;
    }

    private function getAddonView($productId, $popupBlocks, $addonType)
    {
        $view["tabs"] = $this->renderView('ATrophyMeatBundle:Inventory:popupLayout.html.twig', [
            'productId'   => $productId,
            'popupBlocks' => $popupBlocks,
            'addonType'   => $addonType
        ]);

        return $view;
    }

    /* Set Addons */

    public function addAction($productId, Request $request)
    {
        $addonItem = $request->request->get('addon');

        $etchingText  = ( $request->request->get('etching') ) ? $request->request->get('etching') : [];
        $etchingImage = ( $request->files->get('etching') ) ? $request->files->get('etching') : [];

        $etching = array_merge_recursive($etchingText, $etchingImage);

        if( $addonItem ) {
            //handle static items
            if( !($addonViewsSet = $this->addAddonItem($productId, $addonItem)) )
                return $this->getError();

            return new Response(json_encode($addonViewsSet), 200);
        } elseif( $etching ) {
            //handle custom data
            if( !($addonViewsSet = $this->addEtching($productId, $etching)) )
                return $this->getError();

            return new Response(json_encode($addonViewsSet), 200);
        } else {
            return $this->getError();
        }
    }

    private function addAddonItem($productId, $addonItem)
    {
        $product = $this->get('atrophy.shop_page_data')->getProduct($productId);

        if( !$product ) {
            return FALSE;
        } else {
            $product = $product[0];
        }

        //Hotfix
        $itemSpecifications = $this->getItemSpecifications($product);
        //END\Hotfix

        $addonItem = [
            'type'               => key($addonItem),
            'itemId'             => current($addonItem),
            //Hotfix
            'itemSpecifications' => $itemSpecifications
            //END\Hotfix
        ];

        if( !$product->getProductAddon()->checkAddonAvailbility($addonItem['type']) )
            return FALSE;

        if( !($addonData = $this->getAddonData($addonItem['type'], $addonItem)) )
            return FALSE;

        $addons = $this->get('atrophy.inventory_page_data')->saveAddonData($productId, $addonItem['type'], $addonData);

        if( !($addonViewsSet = $this->addonViewsSet($productId, $addonItem['itemId'], $addonItem['type'], $addons)) )
            return FALSE;

        return $addonViewsSet;
    }

    private function addEtching($productId, $etching)
    {
        $etchingType = key($etching);

        if( empty($etching[$etchingType]['text']) && empty($etching[$etchingType]['image']) )
            return FALSE;

        $product = $this->get('atrophy.shop_page_data')->getProduct($productId);

        if( !$product ) {
            return FALSE;
        } else {
            $product = $product[0];
        }

        //Hotfix
        $itemSpecifications = $this->getItemSpecifications($product);
        //END\Hotfix

        $etching = [
            'type'               => $etchingType,
            'text'               => ( !empty($etching[$etchingType]['text']) ) ? $etching[$etchingType]['text'] : NULL,
            'image'              => ( !empty($etching[$etchingType]['image']) ) ? $etching[$etchingType]['image'] : NULL,
            //Hotfix
            'itemSpecifications' => $itemSpecifications
            //END\Hotfix
        ];

        if( !$product->getProductAddon()->checkAddonAvailbility($etching['type']) )
            return FALSE;

        if( !($addonData = $this->getAddonData($etching['type'], $etching)) )
            return FALSE;

        $addons = $this->get('atrophy.inventory_page_data')->saveAddonData($productId, $etching['type'], $addonData);

        if( !($addonViewsSet = $this->addonViewsSet($productId, NULL, $etching['type'], $addons)) )
            return FALSE;

        return $addonViewsSet;
    }

    private function getAddonData($addonType, $addonParameters)
    {
        $_inventoryPageData = $this->get('atrophy.inventory_page_data');

        $addonData = [];

        switch($addonType)
        {
            case ProductAddon::STATUETTE:
                $addonData = $_inventoryPageData->getStatuetteData($addonParameters['itemId']);
            break;

            case ProductAddon::TOPTOKEN:
                if( !empty($addonParameters['text']) || !empty($addonParameters['image']) ) {
                    $addonData = $_inventoryPageData->getCustomTopTokenData($addonParameters);
                } else {
                    $addonData = $_inventoryPageData->getTopTokenData($addonParameters);
                }
            break;

            case ProductAddon::TOKEN:
                if( !empty($addonParameters['text']) || !empty($addonParameters['image']) ) {
                    $addonData = $_inventoryPageData->getCustomTokenData($addonParameters);
                } else {
                    $addonData = $_inventoryPageData->getTokenData($addonParameters['itemId']);
                }
            break;

            case ProductAddon::RIBBON:
                $addonData = $_inventoryPageData->getRibbonData($addonParameters['itemId']);
            break;

            case ProductAddon::BOX:
                $addonData = $_inventoryPageData->getBoxData($addonParameters['itemId']);
            break;

            case ProductAddon::PLATE:
                $addonData = $_inventoryPageData->getPlateData($addonParameters);
            break;

            case ProductAddon::ETCHING:
                $addonData = $_inventoryPageData->getEtchingData($addonParameters);
            break;
        }

        return $addonData;
    }

    private function addonViewsSet($productId, $addonItemId, $addonType, $addons)
    {
        $data = json_encode(['addonType' => $addonType]);

        $views["cellView"] = $this->renderView('ATrophyMeatBundle:Inventory:addonCell.html.twig', [
            'productId' => $productId,
            'data'      => $data,
            'image'     => $addons[$productId][$addonType]['image']
        ]);

        $totalPrice = $this->get('atrophy.inventory_page_data')->countAddonsTotalPrice($productId, $addons);

        $views["addOnsCost"] = $this->renderView('ATrophyMeatBundle:Inventory:addonItems.html.twig', [
            'addons' => $addons[$productId]
        ]);

        return $views;
    }

    /* Delete addons */

    public function deleteAction($productId, Request $request)
    {
        $addonType = $request->request->get('addonType');

        if( empty($addonType) ) {
            return $this->getError();
        }

        $_inventoryPageData = $this->get('atrophy.inventory_page_data');

        if( !($savedAddon = $_inventoryPageData->selectSavedAddon($productId, $addonType)) ) {
            return $this->getError();
        }

        $addonName = $savedAddon['name'];

        $addons = $_inventoryPageData->unsetSavedAddon($productId, $addonType);

        if( !($addonViewsSet = $this->addonUpdatedViewsSet($productId, $addonName, $addons)) )
            return FALSE;


        return new Response(json_encode($addonViewsSet), 200);
    }

    private function addonUpdatedViewsSet($productId, $addonName, $addons)
    {
        $views["cellView"] = "<a href='#' class='darkGray orangeHover easeInOutQuad'>{$addonName}</a>";

        $totalPrice = $this->get('atrophy.inventory_page_data')->countAddonsTotalPrice($productId, $addons);

        $views["addOnsCost"] = $this->renderView('ATrophyMeatBundle:Inventory:addonItems.html.twig', [
            'addons' => $addons[$productId]
        ]);

        return $views;
    }

    /* Rating */
	
	public function rateAction(Request $request)
	{
        #Checkout

		if( !$request->request->get('modelId') ||
			!$request->request->get('rating') ) {
			return $this->getErrorPlain();
		} else {
            $productId = $request->request->get('modelId');
            $rating  = $request->request->get('rating');
        }

        $_session = $this->get('session');

        if( !$_session->has('rated_products') ) {
            $rated_products = [];
        } else {
            $rated_products = $_session->get('rated_products');
        }

        if( $this->isProductRated($rated_products, $productId) ) {
            return $this->getErrorPlain("Вы уже оценили этот товар");
        } else {
            $rated_products[] = $productId;
        }

        #END\Checkout

        $_manager = $this->getDoctrine()->getManager();

		$_shopPageData = $this->get('atrophy.shop_page_data');

		$product = $_shopPageData->getNeatProductById($productId);

        if( !$product ) {
            return $this->getErrorPlain();
        }
		
		$newVotersNumber = $product->getRatingVotes() + 1;
		$newRatingScore  = (($product->getRatingScore() * $product->getRatingVotes()) + $rating) / ($newVotersNumber);

        $product->setRatingVotes($newVotersNumber)
            ->setRatingScore($newRatingScore);
        $_manager->persist($product);

        $_manager->flush();

        $rateResponse = $this->getRateResponse($productId, $newRatingScore, $newVotersNumber);

        if( empty($rateResponse) ) {
            return $this->getErrorPlain();
        }

        $_session->set('rated_products', $rated_products);

        return new Response(json_encode($rateResponse), 200);
    }

    private function isProductRated($rated_products, $productId) {
        return ( in_array($productId, $rated_products, TRUE) ) ? TRUE : FALSE;
    }

    private function getRateResponse($productId, $newRatingScore, $newVotersNumber)
    {
        $rateResponse['rating'] = $this->renderView('ATrophyMeatBundle:ShopPageData:rating.html.twig', [
            'productId'   => $productId,
            'ratingScore' => round($newRatingScore),
            'ratingVotes' => $newVotersNumber
        ]);

        $rateResponse['message'] = "<p>Ваш голос учтен!</p>";

        return $rateResponse;
    }
}