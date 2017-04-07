<?php
// src/ATrophy/Bundle/MeatBundle/Controller/CartController.php
namespace ATrophy\Bundle\MeatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

use ATrophy\Bundle\MeatBundle\Controller\Contract\CartInitInterface;

use ATrophy\Entity\Order\Order,
    ATrophy\Bundle\MeatBundle\Form\Type\OrderType,
    ATrophy\Service\Cart;

class CartController extends Controller implements CartInitInterface
{
	private function getError($message = NULL)
    {
        if( !$message ) {
            $message = "Ошибка при выполнении запроса";
        }

        return new Response("<p>{$message}</p>", 500);
    }

    public function productsAction(Request $request)
    {
        if( $request->request->has('productId') && $request->request->has('items') ) {
            $this->addToCart($request->request->get('productId'), $request->request->get('items'));

            return $this->redirect($this->generateUrl('atrophy_meat_cart'));
        }
		
		$_cart = $this->get('atrophy.cart');

        $cartItems = $_cart->getCart();

        $ids = $_cart->getCartProductsIds($cartItems);

        $cartProducts = $this->get('atrophy.shop_page_data')->getProductsByIds($ids);

        $backLink = $this->getBackLink();

        return $this->render('ATrophyMeatBundle:Cart:products.html.twig', [
            'route'        => $this->get('atrophy.common_page_data')->getRoute(),
            'cartItems'    => $cartItems,
            'cartProducts' => $cartProducts,
            'backLink'     => $backLink
        ]);
    }

    public function checkoutAction(Request $request)
    {
        if( $this->get('session')->has('result') )
        {
            $result = $this->get('session')->get('result');

            $this->get('session')->remove('result');

            return $this->render('ATrophyMeatBundle:Cart:checkout.html.twig', [
                'result' => $result
            ]);
        }

        if( !$this->get('session')->has(Cart::SESSION_CART) ) {
            return $this->redirect($this->generateUrl('atrophy_meat_cart'));
        }

        $errorsArray = [];

        $order = new Order;

        $form = $this->createForm(new OrderType, $order);

        $form->handleRequest($request);

        if( $form->isSubmitted() )
        {
            $validator = $this->get('validator');

            if( $form['deliveryType']->getData() == 'selfDelivery' ) {
                $errors = $validator->validate($order, ['Default']);
            } else {
                $errors = $validator->validate($order, ['shopDelivery', 'Default']);
            }

            if( count($errors) > 0 ) {
                foreach($errors as $error) {
                    $errorsArray[$error->getPropertyPath()] = $error->getMessage();
                }
            } else {
                $this->get('session')->set('result', $this->get('atrophy.order')->processOrder($order));

                $this->get('atrophy.cart')->clearCart();

                return $this->redirect($this->generateUrl('atrophy_meat_cart_checkout'));
            }
        }

        $regions = $this->get('atrophy.meat_page_data')->getOrderedRegions();

        return $this->render('ATrophyMeatBundle:Cart:checkout.html.twig', [
            'form'        => $form->createView(),
            'errorsArray' => $errorsArray,
            'regions'     => $regions
        ]);
    }

    public function quantityAction(Request $request)
    {
        if( !$request->request->has('cartItemId') || !$request->request->has('action') )
            return $this->getError();

        $cartItemId = $request->request->get('cartItemId');
        $action     = $request->request->get('action');
		
		$_cart = $this->get('atrophy.cart');
		
        $cartItems = $_cart->getCart();

        if( empty($cartItems[$cartItemId]) )
            return $this->getError();

        //check quantity variable is int not null
        if( $action === 'set' && (int)$request->request->get('quantity') ) {
            $quantity = $request->request->get('quantity');
        } else {
            $quantity = $cartItems[$cartItemId]['quantity'];
        }

		$ids = $_cart->getCartProductsIds($cartItems);
			
        $cartProducts = $this->get('atrophy.shop_page_data')->getProductsByIds($ids);

		$cartItems[$cartItemId]['quantity'] = $this->get('atrophy.cart')
			->changeQuantity($action, $quantity);
		
        if( !$cartItems[$cartItemId]['quantity'] )
			return $this->getError();

		$subtotalPrices = $this->get('atrophy.cart')
			->getCartSubtotalPrices($cartItems, $cartProducts);

        $_cart->setCart($cartItems);

        $response = [
            'quantity'      => $cartItems[$cartItemId]['quantity'],
            'subtotalPrice' => number_format($subtotalPrices[$cartItemId], 2),
            'totalPrice'    => number_format(array_sum($subtotalPrices), 2)
        ];

		return new Response(json_encode([
			'quantity'      => $response['quantity'],
			'totalQuantity' => ( $_cart->countCartItems() > 0 ) ? $_cart->countCartItems() : '',
			'subtotalPrice' => "{$response['subtotalPrice']} UAH",
			'totalPrice'    => "{$response['totalPrice']} UAH"
		]), 200);
    }

    public function deleteItemAction(Request $request)
    {
        if( !$request->request->has('cartItemId') )
            return $this->getError();

        $cartItemId = $request->request->get('cartItemId');

        $_cart = $this->get('atrophy.cart');

        $cartItems = $_cart->getCart();
        $cartItems = $_cart->deleteCartItem($cartItems, $cartItemId);
        $_cart->setCart($cartItems);

        $ids = $_cart->getCartProductsIds($cartItems);
        $cartProducts = $this->get('atrophy.shop_page_data')->getProductsByIds($ids);

        $subtotalPrices = $_cart->getCartSubtotalPrices($cartItems, $cartProducts);
        $totalPrice = number_format(array_sum($subtotalPrices), 2);

        $cartItemsNumber = $_cart->countCartItems();

        return new Response(json_encode([
            'totalPrice'    => "{$totalPrice} UAH",
            'totalQuantity' => ( $_cart->countCartItems() > 0 ) ? $_cart->countCartItems() : '',
            'cartEmpty'     => ( $cartItemsNumber == 0 ) ? "<p class='orange cartEmpty'>На данный момент в вашей корзине пусто</p>" : FALSE,
        ]), 200);
    }

    private function addToCart($productId, $newItems)
    {
        $newItems = array_keys(array_filter($newItems));

        if( empty($productId) || empty($newItems) )
            return FALSE;

        $_inventoryPageData = $this->get('atrophy.inventory_page_data');

        $_cart = $this->get('atrophy.cart');

        $addons      = $_inventoryPageData->obtainAddonData($productId);
        $addonsPrice = $_inventoryPageData->countSingleAddonsTotalPrice($addons);

        $_cart->addToCart($productId, $addons, $addonsPrice, $newItems);
    }

    private function getBackLink()
    {
        if( !$this->get('session')->has('previous_page') ) {
            $backLink = NULL;
        } else {
            $parameters = [];

            $previousPage = $this->get('session')->get('previous_page');

            if( !empty($previousPage['category']) )
                $parameters['category'] = $previousPage['category'];

            if( !empty($previousPage['id']) )
                $parameters['id'] = $previousPage['id'];

            if( !empty($previousPage['imprint']) )
                $parameters['imprint'] = $previousPage['imprint'];

            $backLink = $this->generateUrl($previousPage['route'], $parameters);
        }

        return $backLink;
    }
}