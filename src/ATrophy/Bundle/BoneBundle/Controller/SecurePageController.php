<?php
// src/ATrophy/Bundle/BoneBundle/Controller/SecurePageController.php
namespace ATrophy\Bundle\BoneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\Security\Core\SecurityContextInterface;

class SecurePageController extends Controller
{
    const ENTITY_CREATE  = 'create';
    const ENTITY_UPDATE  = 'update';
    const ENTITY_DELETE  = 'delete';
    const ENTITY_ADD     = 'add';
    const ENTITY_REMOVE  = 'remove';

    const DELETE_PICTURE = 'delete_picture';

    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        if( $request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR) ) {
            $error = $request->attributes->get(
                SecurityContextInterface::AUTHENTICATION_ERROR
            );
        } elseif( $session->has(SecurityContextInterface::AUTHENTICATION_ERROR) && $session !== NULL ) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        $lastUsername = ( $session === NULL ) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

        return $this->render('ATrophyBoneBundle:Page:login.html.twig', [
                'last_username' => $lastUsername,
                'error'         => $error,
        ]);
    }

    public function indexAction()
    {
        return $this->render('ATrophyBoneBundle:Page:index.html.twig');
    }

    public function productAction($productId = NULL, $action = NULL)
    {
        $_shopPageData = $this->get('atrophy.shop_page_data');

        $categories    = $_shopPageData->loadCategories();
        $subCategories = $_shopPageData->loadSubCategories();
        $thematics     = $_shopPageData->loadOrderedThematics();

        if( $productId )
        {
            if( $action )
            {
                //perform action, redirect to the same page without /action parameter
                switch( $action )
                {
                    case self::ENTITY_UPDATE:
                        $product = $_shopPageData->getAnyProduct($productId);

                        $this->get('CRUD')->updateProduct(
                            $product,
                            $this->get('request')->request->all(),
                            $this->getRequest()->files->all()
                        );

                        $this->get('CRUD')->setProductCurrentValue($productId);
                    break;

                    case self::ENTITY_DELETE:
                        $product = $_shopPageData->getAnyProduct($productId);

                        $this->get('CRUD')->deleteProduct($product);

                        return $this->redirect($this->generateUrl('atrophy_bone_homepage'));
                    break;

                    case self::ENTITY_ADD:
                        $product = $_shopPageData->getAnyProduct($productId);

                        $this->get('CRUD')->addProductItem($product);
                    break;

                    case self::ENTITY_REMOVE:
                        $productItem = $_shopPageData->getAnyProductItem($productId);

                        $productId = $this->get('CRUD')->removeProductItem($productItem);

                        $this->get('CRUD')->setProductCurrentValue($productId);
                    break;

                    case self::DELETE_PICTURE:
                        $product = $_shopPageData->getAnyProduct($productId);

                        $this->get('CRUD')->removeProductPicture($product);
                    break;
                }

                return $this->redirect($this->generateUrl('atrophy_bone_product', ['productId' => $productId]));
            }

            //select item and render form with item
            $product = $_shopPageData->getAnyProduct($productId);

            if( !$product ) {
                return $this->redirect($this->generateUrl('atrophy_bone_product'));
            }

            return $this->render('ATrophyBoneBundle:Page:productEdit.html.twig', [
                'product'       => $product,
                'categories'    => $categories,
                'subCategories' => $subCategories,
                'thematics'     => $thematics
            ]);
        } else {
            if( $action == self::ENTITY_CREATE ) {
                //create and redirect with id
                $productId = $this->get('CRUD')->createProduct(
                    $this->get('request')->request->all(),
                    $this->getRequest()->files->all()
                );

                return $this->redirect($this->generateUrl('atrophy_bone_product', ['productId' => $productId]));
            } else {
                //render clean form
                return $this->render('ATrophyBoneBundle:Page:productAdd.html.twig', [
                    'categories'    => $categories,
                    'subCategories' => $subCategories,
                    'thematics'     => $thematics
                ]);
            }
        }
    }

    public function addonAction($addonType, $action = NULL, $addonId = NULL)
    {
        $_shopPageData = $this->get('atrophy.shop_page_data');

        if( $action )
        {
            //perform action, redirect to the same page without /action parameter
            switch( $action )
            {
                case self::ENTITY_UPDATE:
                    if( !($addons = $_shopPageData->getAddons($addonType)) ) {
                        return $this->createNotFoundException('Such addon type is not available');
                    }

                    $this->get('CRUD')->updateAddons(
                        $addonType,
                        $addons,
                        $this->get('request')->request->all(),
                        $this->getRequest()->files->all()
                    );
                break;

                case self::ENTITY_ADD:
                    $this->get('CRUD')->addAddon($addonType);
                break;

                case self::ENTITY_REMOVE:
                    $addon = $_shopPageData->getAddon($addonType, $addonId);

                    $this->get('CRUD')->removeAddon($addonType, $addon);
                break;

                case self::DELETE_PICTURE:
                    $addon = $_shopPageData->getAddon($addonType, $addonId);

                    $this->get('CRUD')->removeAddonPicture($addonType, $addon);
                break;
            }

            return $this->redirect($this->generateUrl('atrophy_bone_addon', ['addonType' => $addonType]));
        }

        //select addons by type and render form with item
        $addons = $_shopPageData->getAddons($addonType);

        return $this->render('ATrophyBoneBundle:Page:addonEdit.html.twig', [
            'addonType' => $addonType,
            'addons'    => $addons
        ]);
    }

    public function newsAction($newsId = NULL, $action = NULL)
    {
        $_meatPageData = $this->get('atrophy.meat_page_data');

        if( $newsId )
        {
            if( $action )
            {
                //perform action, redirect to the same page without /action parameter
                switch( $action )
                {
                    case self::ENTITY_UPDATE:
                        $news = $_meatPageData->loadNewsArticle($newsId)[0];

                        $newsId = $this->get('CRUD')->updateNews(
                            $news,
                            $this->get('request')->request->all(),
                            $this->getRequest()->files->all()
                        );
                    break;

                    case self::ENTITY_DELETE:
                        $news = $_meatPageData->loadNewsArticle($newsId)[0];

                        $this->get('CRUD')->deleteNews($news);

                        return $this->redirect($this->generateUrl('atrophy_bone_homepage'));
                    break;

                    case self::DELETE_PICTURE:
                        $news = $_meatPageData->loadNewsArticle($newsId)[0];

                        $this->get('CRUD')->removeNewsPicture($news, $newsId);
                    break;
                }

                return $this->redirect($this->generateUrl('atrophy_bone_news', ['newsId' => $newsId]));
            }

            //select item and render form with item
            $news = $_meatPageData->loadNewsArticle($newsId);

            if( !$news ) {
                return $this->redirect($this->generateUrl('atrophy_bone_news'));
            } else {
                $news = $news[0];
            }

            return $this->render('ATrophyBoneBundle:Page:newsEdit.html.twig', [
                'news' => $news
            ]);
        } else {
            if( $action == self::ENTITY_CREATE ) {
                //create and redirect with id
                $newsId = $this->get('CRUD')->createNews(
                    $this->get('request')->request->all(),
                    $this->getRequest()->files->all()
                );

                return $this->redirect($this->generateUrl('atrophy_bone_news', ['newsId' => $newsId]));
            } else {
                //render clean form
                return $this->render('ATrophyBoneBundle:Page:newsAdd.html.twig');
            }
        }
    }

    public function faqAction($faqId = NULL, $action = NULL)
    {
        $_meatPageData = $this->get('atrophy.meat_page_data');

        if( $faqId )
        {
            if( $action )
            {
                //perform action, redirect to the same page without /action parameter
                switch( $action )
                {
                    case self::ENTITY_UPDATE:
                        $faq = $_meatPageData->loadQuestion($faqId);

                        $faqId = $this->get('CRUD')->updateFaq(
                            $faq,
                            $this->get('request')->request->all()
                        );
                    break;

                    case self::ENTITY_DELETE:
                        $faq = $_meatPageData->loadQuestion($faqId);

                        $this->get('CRUD')->deleteFaq($faq);

                        return $this->redirect($this->generateUrl('atrophy_bone_homepage'));
                    break;
                }

                return $this->redirect($this->generateUrl('atrophy_bone_faq', ['faqId' => $faqId]));
            }

            //select item and render form with item
            $faq = $_meatPageData->loadQuestion($faqId);

            if( !$faq ) {
                return $this->redirect($this->generateUrl('atrophy_bone_news'));
            }

            return $this->render('ATrophyBoneBundle:Page:faqEdit.html.twig', [
                'faq' => $faq
            ]);
        } else {
            if( $action == self::ENTITY_CREATE ) {
                //create and redirect with id
                $faqId = $this->get('CRUD')->createFaq(
                    $this->get('request')->request->all()
                );

                return $this->redirect($this->generateUrl('atrophy_bone_faq', ['faqId' => $faqId]));
            } else {
                //render clean form
                return $this->render('ATrophyBoneBundle:Page:faqAdd.html.twig');
            }
        }
    }

    public function promoAction($action = NULL, $promoId = NULL)
    {
        $_meatPageData = $this->get('atrophy.meat_page_data');

		if( $action )
        {
            switch( $action )
			{
				case self::ENTITY_UPDATE:
                    if( count($this->getRequest()->files->all()) >= 100 )
                        return $this->redirect($this->generateUrl('atrophy_bone_promo'));

                    $this->get('CRUD')->updatePromotions(
                        $this->getRequest()->files->all()
                    );
				break;

				case self::ENTITY_DELETE:
					if( $promoId ) {
                        $promotion = $_meatPageData->loadPromotion($promoId);

                        $this->get('CRUD')->deletePromotion($promotion);
					}
				break;
			}

            return $this->redirect($this->generateUrl('atrophy_bone_promo'));
        } else {
            $promotions = $_meatPageData->loadPromotions();

            return $this->render('ATrophyBoneBundle:Page:promotionsEdit.html.twig', [
                'promotions' => $promotions
            ]);
        }
    }
}