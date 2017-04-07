<?php
// ATrophy/Bundle/MeatBundle/Controller/ShopPageDataController.php
namespace ATrophy\Bundle\MeatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ATrophy\Entity\Shop\Product;

class ShopPageDataController extends Controller
{
    public function catalogGridAction($products)
    {
        $categoryParameter = ( $this->get('session')->has('category_parameter') )
            ? $this->get('session')->get('category_parameter')
            : NULL;

        return $this->render('ATrophyMeatBundle:ShopPageData:catalogGrid.html.twig', [
            'modelRoute'        => $this->get('atrophy.shop_page_data')->getModelRoute(),
            'categoryParameter' => $categoryParameter,
            'isAjaxRequest'     => $this->get('request')->isXmlHttpRequest(),
            'products'          => $products
        ]);
    }

    public function inventoryAction(Product $product)
    {
        $productImages = [];

        $productImages[] = [
            'image'       => $product->getImage(),
            'imageSquare' => $product->getImageSquare(),
            'imageThumb'  => $product->getImageThumb()
        ];

        foreach($product->getProductItem() as $item)
        {
            foreach($item->getItemImage() as $image)
            {
                $productImages[] = [
                    'image'       => $image->getImage(),
                    'imageSquare' => $image->getImageSquare(),
                    'imageThumb'  => $image->getImageThumb()
                ];
            }
        }

        $controllerRoute = 'atrophy_inventory_select';

        return $this->render('ATrophyMeatBundle:ShopPageData:inventory.html.twig', [
            'product'         => $product,
            'productImages'   => $productImages,
            'controllerRoute' => $controllerRoute
        ]);
    }

    public function ratingAction($productId, $ratingVotes = NULL, $ratingScore = NULL)
    {
		if( $ratingScore ) {
			$ratingScore = round($ratingScore);
		}

        return $this->render('ATrophyMeatBundle:ShopPageData:rating.html.twig', [
			'productId'   => $productId,
			'ratingVotes' => $ratingVotes,
			'ratingScore' => $ratingScore
        ]);
    }

    public function thematicFilterAction()
    {
        $route = $this->get('atrophy.common_page_data')->getRoute();

        $allowPromotionFilter = ( $route != 'atrophy_meat_promotions' ) ? TRUE : FALSE;

        $thematics = $this->get('atrophy.shop_page_data')->loadOrderedThematics();

        return $this->render('ATrophyMeatBundle:ShopPageData:thematicFilter.html.twig', [
            'route'                => $this->get('atrophy.common_page_data')->getRoute(),
            'allowPromotionFilter' => $allowPromotionFilter,
            'thematics'            => $thematics
        ]);
    }

    public function sortingFilterAction()
    {
        if( $this->get('session')->has('sorting_parameter') ) {
            $sorting_parameter = $this->get('session')->get('sorting_parameter');
        } else {
            $sorting_parameter = NULL;
        }

        return $this->render('ATrophyMeatBundle:ShopPageData:sortingFilter.html.twig', [
            'route'             => $this->get('atrophy.common_page_data')->getRoute(),
            'sorting_parameter' => $sorting_parameter
        ]);
    }

    public function commonFilterAction()
    {
        $route = $this->get('atrophy.common_page_data')->getRoute();

        $allowPromotionFilter = ( $route != 'atrophy_meat_promotions' ) ? TRUE : FALSE;

        $maxPrice = $this->get('atrophy.shop_page_data')->getMaxPrice();

        if( $this->get('session')->has('filter_parameters') ) {
            $filter_parameters = $this->get('session')->get('filter_parameters');
        } else {
            $filter_parameters = NULL;
        }

        return $this->render('ATrophyMeatBundle:ShopPageData:commonFilter.html.twig', [
            'route'                => $route,
            'allowPromotionFilter' => $allowPromotionFilter,
            'maxPrice'             => $maxPrice,
            'filter_parameters'    => $filter_parameters
        ]);
    }

    public function subcategoryFilterAction()
    {
        if( !$this->get('session')->has('category_parameter') ) {
            throw new \RuntimeException("Missing required property");
        } else {
            $category_parameter = $this->get('session')->get('category_parameter');
        }

        if( $this->get('session')->has('filter_parameters') ) {
            $filter_parameters = $this->get('session')->get('filter_parameters');
        } else {
            $filter_parameters = NULL;
        }

        $subcategories = $this->get('atrophy.shop_page_data')->loadOrderedSubcategories($category_parameter);

        return $this->render('ATrophyMeatBundle:ShopPageData:subcategoryFilter.html.twig', [
            'route'             => $this->get('atrophy.common_page_data')->getRoute(),
            'subcategories'     => $subcategories,
            'filter_parameters' => $filter_parameters
        ]);
    }

    public function specificFilterAction()
    {
        $_shopPageData  = $this->get('atrophy.shop_page_data');

        if( !$this->get('session')->has('category_parameter') ) {
            throw new \RuntimeException("Missing required property");
        } else {
            $category_parameter = $this->get('session')->get('category_parameter');
        }

        if( $this->get('session')->has('filter_parameters') ) {
            $filter_parameters = $this->get('session')->get('filter_parameters');
        } else {
            $filter_parameters = NULL;
        }

        $specifications = $_shopPageData->getSpecifications($category_parameter);

        return $this->render('ATrophyMeatBundle:ShopPageData:specificFilter.html.twig', [
            'specifications'    => $specifications,
            'filter_parameters' => $filter_parameters
        ]);
    }
}