<?php
// ATrophy/Bundle/MeatBundle/EventListener/PageInitListener.php
namespace ATrophy\Bundle\MeatBundle\EventListener;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Session\Session,
    Symfony\Component\HttpKernel\Event\FilterControllerEvent;

use ATrophy\Bundle\MeatBundle\Controller\Contract\PageInitInterface,
    ATrophy\Bundle\MeatBundle\Controller\Contract\ShopInitInterface,
    ATrophy\Bundle\MeatBundle\Controller\Contract\CartInitInterface;

use ATrophy\Service\CommonPageData,
    ATrophy\Service\FilterParameters;

class PageInitListener
{
    private $_request;
    private $_session;
    private $_commonPageData;
    private $_filterParameters;

    public function __construct(Request $request, Session $session, CommonPageData $commonPageData, FilterParameters $filterParameters)
    {
        $this->_request          = $request;
        $this->_session          = $session;
        $this->_commonPageData   = $commonPageData;
        $this->_filterParameters = $filterParameters;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if( !$event->getRequestType() ) {
            return FALSE;
        }

        $controller = $event->getController();

        $route = $this->_request->get('_route');

        if( $controller[0] instanceof PageInitInterface ) {
            $this->setPageData($route);
            $this->clearSessionFilters();
            $this->setShopPagePath($route);

            $this->clearSessionAddons();
        }

        if( $controller[0] instanceof ShopInitInterface ) {
            $this->setPageData($route);
            $this->clearSessionFiltersByRouteCategory($route);
            $this->setShopPagePath($route);

            $this->clearSessionAddons();
        }

        if( $controller[0] instanceof CartInitInterface ) {
			if( !$this->_request->isXmlHttpRequest() )
				$this->setPageData($route);
        }
    }

    private function setPageData($route)
    {
        $this->_commonPageData->setRoute($route);
        $this->_commonPageData->setUrl($this->_request->getUri());

        $this->_commonPageData->loadMetadata($route);
        $this->_commonPageData->loadDirectories($route);
        $this->_commonPageData->loadContacts();

        $this->_commonPageData->setImage("logo_large.jpg");
    }

    private function clearSessionFilters()
    {
        if( !$this->_request->isXmlHttpRequest() )
        {
            $this->_filterParameters->clearParameters();
            $this->clearSessionPagination();
        }
    }

    private function clearSessionFiltersByRouteCategory($route)
    {
        if( !$this->_request->isXmlHttpRequest() )
        {
            if (!$this->_session->has('previous_page')) {
                $this->clearSessionFilters();
            } else {
                $previous_page = $this->_session->get('previous_page');

                $isOtherPage = $previous_page['route'] != $route || $previous_page['category'] != $this->_request->get('category');

                if ($isOtherPage) {
                    if( !in_array($route, ['atrophy_meat_promotions_model', 'atrophy_meat_shop_model', 'atrophy_meat_thematics_model'], TRUE) ) {
                        $this->clearSessionFilters();
                        $this->clearSessionPagination();
                    }
                }
            }
        }
    }

    private function setShopPagePath($route)
    {
        $previous_page = [
            'route'    => $route,
            'category' => $this->_request->get('category'),
            'id'       => $this->_request->get('id'),
            'imprint'  => $this->_request->get('imprint'),
        ];

        $this->_session->set('previous_page', $previous_page);
    }

    private function clearSessionAddons()
    {
        if( $this->_session->has('addons') ) {
            $this->_session->remove('addons');
        }
    }

    private function clearSessionPagination()
    {
        if( $this->_session->has('pagination') ) {
            $this->_session->remove('pagination');
        }
    }
}