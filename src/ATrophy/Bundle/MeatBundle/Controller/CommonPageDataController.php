<?php
// ATrophy/Bundle/MeatBundle/Controller/CommonPageDataController.php
namespace ATrophy\Bundle\MeatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommonPageDataController extends Controller
{
    public function metadataAction()
    {
        $metadata = $this->get('atrophy.common_page_data')->getMetadata();

        return $this->render('ATrophyMeatBundle:CommonPageData:metadata.html.twig', [
            'metadata' => $metadata
        ]);
    }

    public function openGraphAction()
    {
        $openGraph  = $this->get('atrophy.common_page_data')->getMetadata();
        $currentUrl = $this->get('atrophy.common_page_data')->getUrl();
        $image      = $this->get('atrophy.common_page_data')->getImage();

        return $this->render('ATrophyMeatBundle:CommonPageData:openGraph.html.twig', [
            'openGraph'  => $openGraph,
            'currentUrl' => $currentUrl,
            'image'      => $image
        ]);
    }

    public function headerAction()
    {
        $contacts = $this->get('atrophy.common_page_data')->getContacts();

        $cartItemsNumber = $this->get('atrophy.cart')->countCartItems();

        return $this->render('ATrophyMeatBundle:CommonPageData:header.html.twig', [
            'contacts'        => $contacts,
            'cartItemsNumber' => $cartItemsNumber
        ]);
    }

    public function menuAction()
    {
        $directories = $this->get('atrophy.common_page_data')->getDirectories();

        $_session = $this->get('session');

        $category_parameter = ( $_session->has('category_parameter') )
            ? $_session->get('category_parameter')
            : NULL;

        return $this->render('ATrophyMeatBundle:CommonPageData:menu.html.twig', [
            'directories'        => $directories,
            'category_parameter' => $category_parameter
        ]);
    }

    public function footerAction()
    {
        $directories = $this->get('atrophy.common_page_data')->getDirectories();
        $contacts    = $this->get('atrophy.common_page_data')->getContacts();

        return $this->render('ATrophyMeatBundle:CommonPageData:footer.html.twig', [
            'directories' => $directories,
            'contacts'    => $contacts
        ]);
    }

    public function paginationBarAction()
    {
        $paginationBar = $this->get('atrophy.pagination_bar')->getPaginationBar();

        if( $this->get('session')->has('category_parameter') ) {
            $category = $this->get('session')->get('category_parameter');
        } else {
            $category = NULL;
        }

        return $this->render('ATrophyMeatBundle:CommonPageData:paginationBar.html.twig', [
            'route'         => $this->get('atrophy.common_page_data')->getRoute(),
            'category'      => $category,
            'paginationBar' => $paginationBar
        ]);
    }
	
	public function navigationBarAction()
	{
		if( !$this->get('session')->has('breadcrumbs') ) {
			throw new \InvalidArgumentException('No routes array is defined');
		}

        $breadcrumbs = $this->get('session')->get('breadcrumbs');

        $navigationItems = [];

        foreach($breadcrumbs as $breadcrumb)
        {
            $navigationItems += [$breadcrumb['title'] => $this->generateUrl($breadcrumb['route'], $breadcrumb['parameters'])];
        }

		return $this->render('ATrophyMeatBundle:CommonPageData:navigationBar.html.twig', [
            'route'           => $this->get('atrophy.common_page_data')->getRoute(),
            'navigationItems' => $navigationItems
        ]);
	}

    public function promotionsAction()
    {
        $promotions = $this->get('atrophy.meat_page_data')->loadPromotions();

        return $this->render('ATrophyMeatBundle:CommonPageData:promotions.html.twig', [
            'promotions' => $promotions
        ]);
    }
}