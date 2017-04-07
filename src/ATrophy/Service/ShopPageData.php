<?php
// ATrophy/Service/ShopPageData.php
namespace ATrophy\Service;

use Doctrine\ORM\EntityManager;

use Symfony\Component\HttpFoundation\Session\Session;

class ShopPageData
{
    const BUNDLE = 'ATrophy\Entity\Shop';

    private $_manager;
    private $_session;
	private $_paginationBar;
    private $_dataTransform;

    private $modelRoute;

    private $_securityContext;

    public function __construct(EntityManager $manager, Session $session, PaginationBar $paginationBar, DataTransform $dataTransform, $securityContext)
    {
        $this->_manager       = $manager;
        $this->_session       = $session;
		$this->_paginationBar = $paginationBar;
        $this->_dataTransform = $dataTransform;

        $this->_securityContext = $securityContext;
    }

    public function getNeatProductById($id)
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Product')
            ->findNeatProduct($id);
    }

    public function getProductsByIds($ids)
    {
        $products = $this->_manager
            ->getRepository(self::BUNDLE . '\Product')
            ->findProductsByIds($ids, $this->_securityContext->isGranted('ROLE_ADMIN'));

        return $this->formatCartProducts($products);
    }

	public function filterProducts(array $parameters, array $pagination, $searchString = NULL)
	{
		$products = $this->loadProducts(
            $parameters['category'],
			$parameters['thematic'],
			$parameters['filters'],
			$parameters['sorting'],
			$pagination,
            $searchString
		);

        $paginationParameters = $this->_paginationBar->setParameters(
            count($products),
			$pagination['records_per_page'],
			$pagination['current_page'],
			$pagination['pages_step']
        );

        if( $paginationParameters ) {
            $this->_paginationBar->setPaginationBar();
        } else {
            return FALSE;
        }

        return $this->formatProducts($products);
	}

    public function loadProducts($category_parameter = NULL, $thematic_parameter = NULL, array $filter_parameters = NULL, $sorting_parameter = NULL, array $pagination = NULL, $searchString = NULL)
    {
        if( empty($category_parameter) && $this->_session->has('category_parameter') ) {
            $category_parameter = $this->_session->get('category_parameter');
        }

        if( empty($thematic_parameter) && $this->_session->has('thematic_parameter') ) {
            $thematic_parameter = $this->_session->get('thematic_parameter');
        }

        if( empty($filter_parameters) && $this->_session->has('filter_parameters') ) {
            $filter_parameters = $this->_session->get('filter_parameters');
        }

        if( empty($sorting_parameter) && $this->_session->has('sorting_parameter') ) {
            $sorting_parameter = $this->_session->get('sorting_parameter');
        }

        if( !empty($searchString) ) {
            $products = $this->_manager
                ->getRepository(self::BUNDLE . '\Product')
                ->findBySearchString($searchString, $pagination, $this->_securityContext->isGranted('ROLE_ADMIN'));
        } else {
            $products = $this->_manager
                ->getRepository(self::BUNDLE . '\Product')
                ->findProducts($category_parameter, $thematic_parameter, $filter_parameters, $sorting_parameter, $pagination, $this->_securityContext->isGranted('ROLE_ADMIN'));
        }

        return $products;
    }

    private function formatProducts($products)
    {
        $formattedProducts = [];

        foreach($products as $product)
        {

            $min_promo_price = $min_price = $is_promo = $is_stock = FALSE;

            $prices = $pricesPromo = [];

            foreach($product->getProductItem() as $key => $item)
            {
                $prices[$key]      = $item->getPrice();
                $pricesPromo[$key] = $item->getPricePromo();

                if( $item->getPricePromo() ) {
                    $is_promo = TRUE;
                }

                if( $item->getStock() ) {
                    $is_stock = TRUE;
                }
            }

            if( $prices ) {
                $min_price_key = array_keys($prices, min($prices))[0];
                $min_price     = $prices[$min_price_key];
            }

            if( isset($min_price_key) )
            {
                if (!empty($pricesPromo[$min_price_key])) {
                    $min_promo_price = $pricesPromo[$min_price_key];
                }
            }

            $formattedProducts[] = [
                'id'            => $product->getId(),
                'title'         => $product->getTitle(),
                'imageThumb'    => $product->getImageThumb(),
                'minPrice'      => $min_price,
                'minPromoPrice' => $min_promo_price,
                'isPromo'       => $is_promo,
                'isStock'       => $is_stock,
                'imprint'       => $product->getImprint(),
                'ratingScore'   => round($product->getRatingScore()),
                'isVisible'     => $product->getIsVisible()
            ];
        }

        return $formattedProducts;
    }

    private function formatCartProducts($products)
    {
        $formattedProducts = [];

        foreach($products as $product)
        {
            $formattedProducts[$product['id']] = $product;

            unset($formattedProducts[$product['id']]['productItem']);

            foreach($product['productItem'] as $productItem)
            {
                $formattedProducts[$product['id']]['productItem'][$productItem['id']] = $productItem;

                $formattedProducts[$product['id']]['productItem'][$productItem['id']]['itemImage'] =
                    ( ($existingImage = $this->getItemExistingImage($product['productItem'], $productItem['id'])) )
                    ? $existingImage
                    : $product['imageThumb'];

                $formattedProducts[$product['id']]['productItem'][$productItem['id']]['itemSpecification'] = array_filter([
                    'color'          => $productItem['itemSpecification']['color'],
                    'colorTouch'     => $productItem['itemSpecification']['colorTouch'],
                    'height'         => $productItem['itemSpecification']['height'],
                    'diameterMedal'  => $productItem['itemSpecification']['diameterMedal']
                ]);
            }
        }

        return $formattedProducts;
    }

    private function getItemExistingImage($productItem, $productItemId)
    {
        foreach($productItem as $item)
        {
            foreach($item['itemImage'] as $itemImage)
            {
                if( empty($itemImage['imageThumb']) )
                    continue;

                $itemImages[] = $itemImage['imageThumb'];

                if( $item['id'] == $productItemId )
                    return $itemImage['imageThumb'];
            }
        }

        return ( !empty($itemImages[0]) ) ? $itemImages[0] : NULL;
    }

    public function getSpecifications($category_parameter)
    {
        $specifications = [];

        $specifications = $this->_manager
            ->getRepository(self::BUNDLE . '\ItemSpecification')
            ->findSpecificationsByCategory($category_parameter);

        switch($category_parameter)
        {
            case 'goblets':
                $transformLambda = function($input_array) {
                    $output_array = [];

                    foreach($input_array as $value) {
                        $output_array['height'][]         = $value->getHeight();
                        $output_array['diameterGoblet'][] = $value->getDiameterGoblet();
                        $output_array['color'][]          = $value->getColor();
                        $output_array['colorTouch'][]     = $value->getColorTouch();
                    }

                    foreach($output_array as $key => $value) {
                        $output_array[$key] = array_filter(array_unique($value));
                        sort($output_array[$key]);
                    }

                    return $output_array;
                };
                break;

            case 'medals':
                $transformLambda = function($input_array) {
                    $output_array = [];

                    foreach($input_array as $value) {
                        $output_array['diameterMedal'][] = $value->getDiameterMedal();
                    }

                    foreach($output_array as $key => $value) {
                        $output_array[$key] = array_filter(array_unique($value));
                        sort($output_array[$key]);
                    }

                    return $output_array;
                };
                break;

            case 'statuettes':
                $transformLambda = NULL;
                break;

            case 'awards':
                $transformLambda = NULL;
                break;
        }

        if( $specifications && !empty($transformLambda) ) {
            $specifications = $this->_dataTransform->transform($specifications, $transformLambda);
        } else {
            $specifications = NULL;
        }

        return $specifications;
    }

    public function setModelRoute($route)
    {
        $this->modelRoute = $route;
    }

    public function getModelRoute()
    {
        return $this->modelRoute;
    }

	public function loadOrderedThematics()
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Thematic')
            ->findAllAlphabetOrdered();
    }

    public function loadDefaultThematicId()
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Thematic')
            ->findDefaultThematic()
            ->getId();
    }

    public function getThematicById($thematicId)
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Thematic')
            ->find($thematicId)
            ->getTitle();
    }

    public function getMaxPrice()
    {
         $maxPrice = $this->_manager
            ->getRepository(self::BUNDLE . '\ProductItem')
            ->findMaxPrice();

        return ceil($maxPrice);
    }

    public function loadOrderedSubcategories($category)
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Category')
            ->findSubcategoriesByCategory($category);
    }

    public function getCategoryByParameter($parameter)
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Category')
            ->findByParameter($parameter)
            ->getTitle();
    }

    public function getProduct($id)
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Product')
            ->findProduct($id, $this->_securityContext->isGranted('ROLE_ADMIN'));
    }

    //DEM

    public function getAnyProduct($id)
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Product')
            ->findAny($id);
    }

    public function getAnyProductItem($id)
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\ProductItem')
            ->findAnyProductItem($id);
    }

    public function loadCategories()
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Category')
            ->findAllCategories();
    }

    public function loadSubCategories()
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Category')
            ->findAllSubCategories();
    }

    public function getTokens()
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Token')
            ->findAll();
    }

    public function getToken($id)
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Token')
            ->find($id);
    }

    public function getRibbons()
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Ribbon')
            ->findAll();
    }

    public function getRibbon($id)
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Ribbon')
            ->find($id);
    }

    public function getBoxes()
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Box')
            ->findAll();
    }

    public function getBox($id)
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Box')
            ->find($id);
    }

    public function getAddons($addonType)
    {
        switch( $addonType )
        {
            case 'token':
                $addons = $this->getTokens();
            break;

            case 'ribbon':
                $addons = $this->getRibbons();
            break;

            case 'box':
                $addons = $this->getBoxes();
            break;

            default:
                return FALSE;
            break;
        }

        return $addons;
    }

    public function getAddon($addonType, $id)
    {
        switch( $addonType )
        {
            case 'token':
                $addon = $this->getToken($id);
            break;

            case 'ribbon':
                $addon = $this->getRibbon($id);
            break;

            case 'box':
                $addon = $this->getBox($id);
            break;

            default:
                return FALSE;
            break;
        }

        return $addon;
    }
}
