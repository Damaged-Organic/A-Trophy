<?php
// ATrophy/Bundle/MeatBundle/Controller/ShopFilterController.php
namespace ATrophy\Bundle\MeatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response;

class ShopFilterController extends Controller
{
    public function catalogElementsAction()
    {
        $session = $this->get("session");

		$_shopPageData     = $this->get('atrophy.shop_page_data');
        $_filterParameters = $this->get('atrophy.filter_parameters');

        $parameters = $_filterParameters->getCheckedParameters();

        $_filterParameters->saveParameters($parameters);

        if( !$session->has('pagination') ) {
            $pagination = NULL;
        } else {
            $pagination = $session->get('pagination');
            $pagination['current_page'] = 1;

            if( ($count = (int)$this->get('request')->request->get('count')) ) {
                $pagination['records_per_page'] = $count;
            }

            $session->set('pagination', $pagination);
        }

        $products = $_shopPageData->filterProducts($parameters, $pagination);

        $views = $this->getCatalogElementsViews($products);

        return ( !empty($views) )
            ? new Response(json_encode($views, TRUE), 200)
            : new Response('Internal server error', 500);
    }

    private function getCatalogElementsViews($products)
    {
        $_session = $this->get("session");

        $_shopPageData = $this->get('atrophy.shop_page_data');

        if( !$_session->has('route') || !$_session->has('modelRoute') ) {
            return FALSE;
        } else {
            $route      = $_session->get('route');
            $modelRoute = $_session->get('modelRoute');
        }

        if( $this->get('session')->has('category_parameter') ) {
            $category = $this->get('session')->get('category_parameter');
        } else {
            $category = NULL;
        }

        if( $_session->has('breadcrumbs') && $_session->has('thematic_parameter') )
        {
            $breadcrumbs = $_session->get('breadcrumbs');

            #HORRIBLE KLUDGE - Call the Inquisition!
            $endElement = end($breadcrumbs);

            $thematics = [];

            foreach($_shopPageData->loadOrderedThematics() as $thematic) {
                $thematics[] = $thematic->getTitle();
            }

            if( !empty($endElement['parameters']['id']) ) {
                $key = key($breadcrumbs);
                unset($breadcrumbs[$key]);
            }

            reset($breadcrumbs);

            $endElement = end($breadcrumbs);

            if( in_array($endElement['title'], $thematics, TRUE) ) {
                $key = key($breadcrumbs);
                unset($breadcrumbs[$key]);
            }

            reset($breadcrumbs);
            #END\HORRIBLE KLUDGE

            $breadcrumbs[] = [
                'route'      => $route,
                'parameters' => ['category' => $category],
                'title'      => $_shopPageData->getThematicById($_session->get('thematic_parameter'))
            ];

            $_session->set('breadcrumbs', $breadcrumbs);
        }
		
		$pageInformation = $this->get('atrophy.pagination_bar')->getPageInformation(count($products));

        $views["grid"] = $this->renderView('ATrophyMeatBundle:ShopPageData:catalogGrid.html.twig', [
            'modelRoute'        => $modelRoute,
            'categoryParameter' => $category,
            'isAjaxRequest'     => $this->get('request')->isXmlHttpRequest(),
            'products'          => $products
        ]);

        $views["navigation"] = $this->renderView('ATrophyMeatBundle:CommonPageData:paginationBar.html.twig', [
            'route'         => $route,
            'category'      => $category,
            'paginationBar' => $this->get('atrophy.pagination_bar')->getPaginationBar()
        ]);

        $views["shown"] = $this->renderView('ATrophyMeatBundle:ShopPageData:pageInformation.html.twig', [
            'route'           => $route,
            'category'        => $category,
            'pageInformation' => $pageInformation
        ]);

        $breadcrumbs = $this->get('session')->get('breadcrumbs');

        $navigationItems = [];

        foreach($breadcrumbs as $breadcrumb)
        {
            $navigationItems += [$breadcrumb['title'] => $this->generateUrl($breadcrumb['route'], $breadcrumb['parameters'])];
        }

        $views["breadcrumbs"] = $this->renderView('ATrophyMeatBundle:CommonPageData:navigationBar.html.twig', [
            'route'           => $route,
            'navigationItems' => $navigationItems
        ]);

        return ( !empty($views) ) ? $views : FALSE;
    }
}