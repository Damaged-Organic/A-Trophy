<?php
// ATrophy/Service/FilterParameters.php
namespace ATrophy\Service;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Session\Session;

use ATrophy\Service\ShopPageData;

class FilterParameters
{
    private $_request;
    private $_session;
    private $_shopPageData;

    public function __construct(Request $request, Session $session, ShopPageData $shopPageData)
    {
        $this->_request      = $request;
        $this->_session      = $session;
        $this->_shopPageData = $shopPageData;
    }

    public function getCheckedParameters()
    {
        $parameters = [
			'category' => NULL,
            'thematic' => NULL,
            'filters'  => NULL,
            'sorting'  => NULL
        ];

        $parameters['category'] = $this->getCheckedCategory();
		$parameters['thematic'] = $this->getCheckedThematic();
        $parameters['filters']  = $this->getCheckedFilters();
        $parameters['sorting']  = $this->getCheckedSorting();

        return $parameters;
    }

    public function saveParameters($parameters)
    {
		if( !empty($parameters['category']) ) {
            $this->_session->set('category_parameter', $parameters['category']);
        }
	
        if( !empty($parameters['thematic']) ) {
            $this->_session->set('thematic_parameter', $parameters['thematic']);
        }

        if( !empty($parameters['filters']) ) {
            $this->_session->set('filter_parameters', $parameters['filters']);
        }

        if( !empty($parameters['sorting']) ) {
            $this->_session->set('sorting_parameter', $parameters['sorting']);
        }
    }

    public function clearParameters()
    {
        if( $this->_session->has('category_parameter') ) {
            $this->_session->remove('category_parameter');
        }

        if( $this->_session->has('thematic_parameter') ) {
            $this->_session->remove('thematic_parameter');
        }

        if( $this->_session->has('filter_parameters') ) {
            $this->_session->remove('filter_parameters');
        }

        if( $this->_session->has('sorting_parameter') ) {
            $this->_session->remove('sorting_parameter');
        }
    }

    public function hasPromoFilters()
    {
        if( $this->_session->has('thematic_parameter') ||
            $this->_session->has('sorting_parameter') ) {
            return TRUE;
        }

        if( $this->_session->has('filter_parameters') )
        {
            $filterParameters = $this->_session->get('filter_parameters');

            if( !empty($filterParameters['is_promo']) ) {
                unset($filterParameters['is_promo']);
            }

            return ( $filterParameters ) ? TRUE : FALSE;
        }
    }

    public function hasShopFilters()
    {
        return (
            $this->_session->has('thematic_parameter') ||
            $this->_session->has('filter_parameters') ||
            $this->_session->has('sorting_parameter')
        );
    }

    public function hasThematicFilters()
    {
        return (
            $this->_session->has('filter_parameters') ||
            $this->_session->has('sorting_parameter')
        );
    }

	private function getCheckedCategory()
    {
        $category = NULL;

        if( $this->_request->request->has('category') )
        {
            $category = $this->_request->request->get('category');
			
			$categories = ['goblets', 'medals', 'statuettes', 'awards'];
			
            $category = ( in_array($category, $categories, TRUE) ) ? $category : NULL;
        }

        return $category;
    }
	
    private function getCheckedThematic()
    {
        $thematic = NULL;

        if( $this->_request->request->has('thematic') )
        {
            $thematic = $this->_request->request->get('thematic');

            $thematic = ( is_int((int)$thematic) ) ? $thematic : NULL;
        }

        return $thematic;
    }

    private function getCheckedFilters()
    {
        $filters = NULL;

        if( $this->_request->request->has('filter') )
        {
            $filter = $this->_request->request->get('filter');

            if( !empty($filter['subcategory']) ) {
                $filters['subcategory'] = $filter['subcategory'];
            }

            if( !empty($filter['color']) ) {
                $filters['color'] = $filter['color'];
            }

            if( !empty($filter['colorTouch']) ) {
                $filters['colorTouch'] = $filter['colorTouch'];
            }

            if( !empty($filter['height']) ) {
                $filters['height'] = $filter['height'];
            }

            if( !empty($filter['diameterGoblet']) ) {
                $filters['diameterGoblet'] = $filter['diameterGoblet'];
            }

            if( !empty($filter['diameterMedal']) ) {
                $filters['diameterMedal'] = $filter['diameterMedal'];
            }

            if( !empty($filter['is_stock']) ) {
                $filters['is_stock'] = ( $filter['is_stock'] === 'yes' ) ? $filter['is_stock'] : NULL;
            } else {
                $filters['is_stock'] = NULL;
            }

            if( !empty($filter['is_promo']) ) {
                $filters['is_promo'] = ( $filter['is_promo'] === 'yes' ) ? $filter['is_promo'] : NULL;
            } else {
                $filters['is_promo'] = NULL;
            }

            if( isset($filter['min_price']) && isset($filter['max_price']) )
            {
                $price = [
                    'min' => 0,
                    'max' => $this->_shopPageData->getMaxPrice()
                ];

                if( $filter['min_price'] != $price['min'] ||
                    $filter['max_price'] != $price['max'] )
                {
                    if( $filter['min_price'] >= $price['min'] &&
                        $filter['max_price'] <= $price['max'] )
                    {
                        $filters['min_price'] = $filter['min_price'];
                        $filters['max_price'] = $filter['max_price'];
                    }
                }
            }
        }

        return $filters;
    }

    private function getCheckedSorting()
    {
        $sorting = NULL;

        if( $this->_request->request->has('sorting') )
        {
            $sorting = $this->_request->request->get('sorting');

            $sorting_options = [
                'alphabetAsc', 'alphabetDesc',
                'priceAsc', 'priceDesc',
                'ratingAsc', 'ratingDesc',
                'newestAsc', 'newestDesc'
            ];

            if( !in_array($sorting, $sorting_options, TRUE) ) {
                $sorting = NULL;
            }
        }

        return $sorting;
    }
}