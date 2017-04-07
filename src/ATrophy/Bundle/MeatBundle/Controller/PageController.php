<?php
// ATrophy/Bundle/MeatBundle/Controller/PageController.php
namespace ATrophy\Bundle\MeatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ATrophy\Bundle\MeatBundle\Controller\Contract\PageInitInterface;

use ATrophy\Entity\Meat\Feedback,
    ATrophy\Bundle\MeatBundle\Form\Type\FeedbackType;

class PageController extends Controller implements PageInitInterface
{
    public function indexAction()
    {
        $directories = $this->get('atrophy.common_page_data')->getDirectories();

        $introItems = $this->get('atrophy.meat_page_data')->loadIntroItems();

        return $this->render('ATrophyMeatBundle:Page:index.html.twig', [
            'route'       => $this->get('atrophy.common_page_data')->getRoute(),
            'directories' => $directories,
            'introItems'  => $introItems
        ]);
    }

    public function aboutUsAction()
    {
        $clients = $this->get('atrophy.meat_page_data')->loadClients();

        return $this->render('ATrophyMeatBundle:Page:about_us.html.twig', [
            'route'   => $this->get('atrophy.common_page_data')->getRoute(),
            'clients' => $clients
        ]);
    }

    public function newsAction($page)
    {
        $results_per_page = 6;
        $pages_step       = 5;

        $news = $this->get('atrophy.meat_page_data')->loadNews($page, $results_per_page);

        $paginationBarSet = $this->get('atrophy.pagination_bar')->setParameters(
            count($news), $results_per_page, $page, $pages_step
        );

        if( $paginationBarSet ) {
            $this->get('atrophy.pagination_bar')->setPaginationBar();
        } else {
            throw $this->createNotFoundException('No such page');
        }

        $monthsNames = $this->get('atrophy.meat_page_data')->getMonthsNames();

        return $this->render('ATrophyMeatBundle:Page:news.html.twig', [
            'route'       => $this->get('atrophy.common_page_data')->getRoute(),
            'news'        => $news,
            'monthsNames' => $monthsNames
        ]);
    }

    public function newsArticleAction($id)
    {
        $monthsNames = $this->get('atrophy.meat_page_data')->getMonthsNames();

        $newsArticle = $this->get('atrophy.meat_page_data')->loadNewsArticle($id);

        if( !$newsArticle ) {
            throw $this->createNotFoundException('No such article exists');
        } else {
            $newsArticle = $newsArticle[0];
        }

        $newsRecent  = $this->get('atrophy.meat_page_data')->loadNews(1, 6);

        $this->get('atrophy.common_page_data')->replaceMetadata([
            'title'       => $newsArticle->getTitle(),
            'description' => $newsArticle->getText()
        ]);

        $this->get('atrophy.common_page_data')->setImage("news/" . $newsArticle->getImageThumb());

        return $this->render('ATrophyMeatBundle:Page:newsArticle.html.twig', [
            'route'       => $this->get('atrophy.common_page_data')->getRoute(),
            'monthsNames' => $monthsNames,
            'newsArticle' => $newsArticle,
            'newsRecent'  => $newsRecent
        ]);
    }

    public function deliveryAndPaymentAction()
    {
        $deliverers = $this->get('atrophy.meat_page_data')->loadDeliverers();
        $payments   = $this->get('atrophy.meat_page_data')->loadPayments();

        return $this->render('ATrophyMeatBundle:Page:delivery_and_payment.html.twig', [
            'route'      => $this->get('atrophy.common_page_data')->getRoute(),
            'deliverers' => $deliverers,
            'payments'   => $payments
        ]);
    }

    public function faqAction()
    {
        $questions = $this->get('atrophy.meat_page_data')->loadQuestions();

        return $this->render('ATrophyMeatBundle:Page:faq.html.twig', [
            'route'     => $this->get('atrophy.common_page_data')->getRoute(),
            'questions' => $questions
        ]);
    }

    public function contactsAction()
    {
        $contacts = $this->get('atrophy.common_page_data')->getContacts();

        $form = $this->createForm(new FeedbackType, new Feedback);

        return $this->render('ATrophyMeatBundle:Page:contacts.html.twig', [
            'route'    => $this->get('atrophy.common_page_data')->getRoute(),
            'contacts' => $contacts,
            'form'     => $form->createView()
        ]);
    }

    public function searchAction($page)
    {
        $_session = $this->get('session');

        $searchString = ( $this->get('request')->request->get('searchString') ) ?: NULL;

        if( $this->get('request')->request->get('searchString') ) {
            $searchString = $this->get('request')->request->get('searchString');
            $_session->set('searchString', $searchString);
            return $this->redirect($this->generateUrl('atrophy_meat_search'));
        }

        if( !$_session->has('searchString') ) {
            return $this->redirect($this->generateUrl('atrophy_meat_homepage'));
        }

        $searchString = $_session->get('searchString');

        $_commonPageData = $this->get('atrophy.common_page_data');
        $_shopPageData   = $this->get('atrophy.shop_page_data');
        $_paginationBar  = $this->get('atrophy.pagination_bar');

        $route      = $_commonPageData->getRoute();
        $modelRoute = 'atrophy_meat_model';
        $_shopPageData->setModelRoute($modelRoute);

        $parameters = [
            'category' => NULL,
            'thematic' => NULL,
            'sorting'  => NULL,
            'filters'  => NULL
        ];

        $pagination = [
            'current_page'     => $page,
            'records_per_page' => 12,
            'pages_step'       => 5
        ];

        $products = $_shopPageData->filterProducts($parameters, $pagination, $searchString);

        if( $products === FALSE ) {
            return $this->redirect($this->generateUrl($route));
        }

        $breadcrumbs = [
            [
                'route'      => $route,
                'parameters' => ['category' => $parameters['category']],
                'title'      => "Поиск"
            ]
        ];

        $_session->set('route', $route);
        $_session->set('modelRoute', $modelRoute);
        $_session->set('breadcrumbs', $breadcrumbs);
        $_session->set('pagination',
            $_paginationBar->getCustomParameters()
        );

        return $this->render('ATrophyMeatBundle:Page:search.html.twig', [
            'searchString' => $searchString,
            'products'     => $products
        ]);
    }
}