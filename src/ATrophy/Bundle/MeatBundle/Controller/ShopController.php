<?php
// ATrophy/Bundle/MeatBundle/Controller/ShopController.php
namespace ATrophy\Bundle\MeatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ATrophy\Bundle\MeatBundle\Controller\Contract\ShopInitInterface;

class ShopController extends Controller implements ShopInitInterface
{
    public function promotionsAction($page)
    {
        $_session = $this->get('session');

        $_commonPageData   = $this->get('atrophy.common_page_data');
        $_shopPageData     = $this->get('atrophy.shop_page_data');
        $_paginationBar    = $this->get('atrophy.pagination_bar');
        $_filterParameters = $this->get('atrophy.filter_parameters');

        $route = $_commonPageData->getRoute();

        if( $this->get('request')->query->get('clear') )
        {
            $_filterParameters->clearParameters();

            if( $_session->has('pagination') ) {
                $_session->remove('pagination');
            }

            return $this->redirect($this->generateUrl($route));
        }

        $modelRoute = 'atrophy_meat_promotions_model';
        $_shopPageData->setModelRoute($modelRoute);

        $parameters = [
            'category' => NULL,
            'thematic' => NULL,
            'sorting'  => NULL,
            'filters'  => NULL
        ];

        if( !$_session->has('filter_parameters') ) {
            $parameters['filters']['is_promo'] = 'yes';
            $_session->set('filter_parameters', $parameters['filters']);
        } else {
            $filter_parameters = $_session->get('filter_parameters');

            if( empty($filter_parameters['is_promo']) || $filter_parameters['is_promo'] !== 'yes' ) {
                $parameters['filters']['is_promo'] = 'yes';
            }
        }

        $pagination = [
            'current_page'     => $page,
            'records_per_page' => 24,
            'pages_step'       => 10
        ];

        if( $_session->has('pagination') )
        {
            $sessionPagination = $_session->get('pagination');
            if( !empty($sessionPagination['records_per_page']) ) {
                $pagination['records_per_page'] = $sessionPagination['records_per_page'];
            }
        }

        $products = $_shopPageData->filterProducts($parameters, $pagination);

        if( $products === FALSE ) {
            return $this->redirect($this->generateUrl($route));
        }

        $pageInformation = $_paginationBar->getPageInformation(count($products));

        $breadcrumbs = [
            [
                'route'      => $route,
                'parameters' => ['category' => $parameters['category']],
                'title'      => $_commonPageData->getNavigationItem($route)
            ]
        ];

        if( $_session->has('thematic_parameter') )
        {
            $breadcrumbs[] = [
                'route'      => $route,
                'parameters' => ['category' => $parameters['category']],
                'title'      => $_shopPageData->getThematicById($_session->get('thematic_parameter'))
            ];
        }

        $_session->set('route', $route);
        $_session->set('modelRoute', $modelRoute);
        $_session->set('breadcrumbs', $breadcrumbs);
        $_session->set('pagination',
            $_paginationBar->getCustomParameters()
        );

        return $this->render('ATrophyMeatBundle:Shop:promotions.html.twig', [
            'route'           => $route,
            'recordsPerPage'  => $pagination['records_per_page'],
            'pageInformation' => $pageInformation,
            'products'        => $products,
            'hasFilters'      => $_filterParameters->hasPromoFilters()
        ]);
    }

    public function shopAction($category, $page)
    {
        $_session = $this->get('session');

        $_commonPageData   = $this->get('atrophy.common_page_data');
        $_shopPageData     = $this->get('atrophy.shop_page_data');
        $_paginationBar    = $this->get('atrophy.pagination_bar');
        $_filterParameters = $this->get('atrophy.filter_parameters');

        $route = $_commonPageData->getRoute();

        if( $this->get('request')->query->get('clear') )
        {
            $_filterParameters->clearParameters();

            if( $_session->has('pagination') ) {
                $_session->remove('pagination');
            }

            return $this->redirect($this->generateUrl($route, ['category' => $category]));
        }

        $modelRoute = 'atrophy_meat_shop_model';
        $_shopPageData->setModelRoute($modelRoute);

        $parameters = [
            'category' => NULL,
            'thematic' => NULL,
            'sorting'  => NULL,
            'filters'  => NULL
        ];

        $parameters['category'] = $category;
		$_session->set('category_parameter', $parameters['category']);

        $pagination = [
            'current_page'     => $page,
            'records_per_page' => 24,
            'pages_step'       => 10
        ];

        if( $_session->has('pagination') )
        {
            $sessionPagination = $_session->get('pagination');
            if( !empty($sessionPagination['records_per_page']) ) {
                $pagination['records_per_page'] = $sessionPagination['records_per_page'];
            }
        }

        $products = $_shopPageData->filterProducts($parameters, $pagination);

        if( $products === FALSE ) {
            return $this->redirect($this->generateUrl($route));
        }

        $pageInformation = $_paginationBar->getPageInformation(count($products));

        $breadcrumbs = [
            [
                'route'      => $route,
                'parameters' => ['category' => $parameters['category']],
                'title'      => $_commonPageData->getNavigationItem($route)
            ],
            [
                'route'      => $route,
                'parameters' => ['category' => $parameters['category']],
                'title'      => $_shopPageData->getCategoryByParameter($parameters['category'])
            ],
        ];

        if( $_session->has('thematic_parameter') )
        {
            $breadcrumbs[] = [
                'route'      => $route,
                'parameters' => ['category' => $parameters['category']],
                'title'      => $_shopPageData->getThematicById($_session->get('thematic_parameter'))
            ];
        }

        $_session->set('route', $route);
        $_session->set('modelRoute', $modelRoute);
        $_session->set('breadcrumbs', $breadcrumbs);
        $_session->set('pagination',
            $_paginationBar->getCustomParameters()
        );

        return $this->render('ATrophyMeatBundle:Shop:shop.html.twig', [
            'route'           => $route,
            'category'        => $parameters['category'],
            'recordsPerPage'  => $pagination['records_per_page'],
            'pageInformation' => $pageInformation,
            'products'        => $products,
            'hasFilters'      => $_filterParameters->hasShopFilters()
        ]);
    }

    public function thematicsAction($page)
    {
        $_session = $this->get('session');

        $_commonPageData   = $this->get('atrophy.common_page_data');
        $_shopPageData     = $this->get('atrophy.shop_page_data');
        $_paginationBar    = $this->get('atrophy.pagination_bar');
        $_filterParameters = $this->get('atrophy.filter_parameters');

        $route = $_commonPageData->getRoute();

        if( $this->get('request')->query->get('clear') )
        {
            $_filterParameters->clearParameters();

            if( $_session->has('pagination') ) {
                $_session->remove('pagination');
            }

            return $this->redirect($this->generateUrl($route));
        }

        $modelRoute = 'atrophy_meat_thematics_model';
        $_shopPageData->setModelRoute($modelRoute);

        $parameters = [
            'category' => NULL,
            'thematic' => NULL,
            'sorting'  => NULL,
            'filters'  => NULL
        ];

        if( !$_session->has('thematic_parameter') ) {
            $parameters['thematic'] = $_shopPageData->loadDefaultThematicId();
            $_session->set('thematic_parameter', $parameters['thematic']);
        } else {
            $parameters['thematic'] = $_session->get('thematic_parameter');
        }

        $pagination = [
            'current_page'     => $page,
            'records_per_page' => 24,
            'pages_step'       => 10
        ];

        if( $_session->has('pagination') )
        {
            $sessionPagination = $_session->get('pagination');
            if( !empty($sessionPagination['records_per_page']) ) {
                $pagination['records_per_page'] = $sessionPagination['records_per_page'];
            }
        }

        $products = $_shopPageData->filterProducts($parameters, $pagination);

        if( $products === FALSE ) {
            return $this->redirect($this->generateUrl($route));
        }

        $pageInformation = $_paginationBar->getPageInformation(count($products));

        $breadcrumbs = [
            [
                'route'      => $route,
                'parameters' => ['category' => $parameters['category']],
                'title'      => $_commonPageData->getNavigationItem($route)
            ],
            [
                'route'      => $route,
                'parameters' => ['category' => $parameters['category']],
                'title'      => $_shopPageData->getThematicById($parameters['thematic'])
            ],
        ];

        $_session->set('route', $route);
        $_session->set('modelRoute', $modelRoute);
        $_session->set('breadcrumbs', $breadcrumbs);
        $_session->set('pagination',
            $_paginationBar->getCustomParameters()
        );

        return $this->render('ATrophyMeatBundle:Shop:thematics.html.twig', [
            'route'           => $route,
            'recordsPerPage'  => $pagination['records_per_page'],
            'pageInformation' => $pageInformation,
            'products'        => $products,
            'hasFilters'      => $_filterParameters->hasThematicFilters()
        ]);
    }

    public function modelAction($category = NULL, $id, $imprint)
    {
        $_session = $this->get('session');

        $_commonPageData = $this->get('atrophy.common_page_data');
        $_shopPageData   = $this->get('atrophy.shop_page_data');

        $route = $_commonPageData->getRoute();

        $product = $_shopPageData->getProduct($id);

        if( !$product ) {
            throw $this->createNotFoundException('No such product exists');
        } else {
            $product = $product[0];
        }

        $breadcrumbs = $_session->get('breadcrumbs');

        #HORRIBLE KLUDGE - Call the Inquisition!
        $endElement = end($breadcrumbs);

        if( !empty($endElement['parameters']['id']) ) {
            $key = key($breadcrumbs);
            unset($breadcrumbs[$key]);
        }

        reset($breadcrumbs);
        #END\HORRIBLE KLUDGE

        $breadcrumbs[] = [
            'route'      => $route,
            'parameters' => ['category' => $category, 'id' => $id, 'imprint' => $imprint],
            'title'      => $product->getTitle()
        ];

        $_session->set('breadcrumbs', $breadcrumbs);

        return $this->render('ATrophyMeatBundle:Shop:model.html.twig', [
            'route'       => $route,
            'product'     => $product
        ]);
    }
}
