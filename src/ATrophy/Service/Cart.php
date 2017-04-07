<?php
// src/ATrophy/Service/Cart.php
namespace ATrophy\Service;

use Doctrine\ORM\EntityManager;

use Symfony\Component\HttpFoundation\Session\Session;

class Cart
{
    const SESSION_CART = 'cart';
	
	const MIN_QUANTITY = 1;
	const MAX_QUANTITY = 10000;

    private $_manager;
    private $_session;
	private $_inventoryPageData;

    public function __construct(EntityManager $manager, Session $session, InventoryPageData $inventoryPageData)
    {
        $this->_manager = $manager;
        $this->_session = $session;
		
		$this->_inventoryPageData = $inventoryPageData;
    }

    public function addToCart($productId, $addons, $addonsPrice, $items)
    {
        $newCartContent = [];

        foreach($items as $item)
        {
            $newCartContent[] = [
                'productId'   => $productId,
                'item'        => $item,
                'addons'      => $addons,
                'addonsPrice' => $addonsPrice,
                'quantity'    => 1
            ];
        }

        $cartContent = $this->getCart();

        foreach($newCartContent as $newCartItem)
        {
            if( ($key = $this->findItemInCart($cartContent, $newCartItem)) !== FALSE ) {
				if( $cartContent[$key]['quantity'] < self::MAX_QUANTITY ) {
					$cartContent[$key]['quantity']++;
				}
			} else {
                $cartContent[] = $newCartItem;
            }
        }

        $this->setCart($cartContent);
    }

    private function findItemInCart($cartContent, $newCartItem)
    {
        foreach($cartContent as $key => $cartItem)
        {
            if( $cartItem['productId'] !== $newCartItem['productId'] ) {
                continue;
            }

            if( $cartItem['item'] !== $newCartItem['item'] ) {
                continue;
            }

            if( $this->compareAddons($cartItem['addons'], $newCartItem['addons']) ) {
                return $key;
            }
        }

        return FALSE;
    }

    private function compareAddons(array $cartAddons, array $newCartAddons)
    {
        if( empty($cartAddons) && !empty($newCartAddons) )
            return FALSE;

        foreach($cartAddons as $key => $value)
        {
            if( !array_key_exists($key, $newCartAddons) ) {
                return FALSE;
            }

            if( is_array($value) && is_array($newCartAddons[$key]) )
            {
                if( !$this->compareAddons($value, $newCartAddons[$key]) )
                    return FALSE;

                continue;
            }

            if( (string)$value !== (string)$newCartAddons[$key] ) {
                return FALSE;
            }
        }

        return TRUE;
    }

    public function getCart()
    {
        return ( $this->_session->has(self::SESSION_CART) )
            ? $this->_session->get(self::SESSION_CART)
            : [];
    }

    public function setCart($cartContent)
    {
        $this->_session->set(self::SESSION_CART, $cartContent);
    }

    public function countCartItems()
    {
		if( !$this->_session->has(self::SESSION_CART) ) {
			return 0;
		}
		
		$totalQuantity = 0;
		
		foreach($this->_session->get(self::SESSION_CART) as $cartItem) {
			$totalQuantity += (int)$cartItem['quantity'];
		}
	
        return $totalQuantity;
    }
	
	public function getCartProductsIds($cartItems)
    {
        $ids = [];

        foreach($cartItems as $cartItem) {
            $ids[] = $cartItem['productId'];
        }

        return $ids;
    }
	
	public function changeQuantity($action, $quantity)
	{
		if( $action === 'increase' ) {
			if( $quantity < self::MAX_QUANTITY ) {
				return ++$quantity;
			} else {
				return self::MAX_QUANTITY;
			}
        } elseif( $action === 'decrease' ) {
            if( $quantity > self::MIN_QUANTITY ) {
                return --$quantity;
            } else {
                return self::MIN_QUANTITY;
            }
        } elseif( $action === 'set' ) {
            if( $quantity <= self::MIN_QUANTITY ) {
                return self::MIN_QUANTITY;
            } elseif( $quantity >= self::MAX_QUANTITY ) {
                return self::MAX_QUANTITY;
            } else {
                return $quantity;
            }
        } else {
            return FALSE;
        }
	}
	
	public function getCartSubtotalPrices($cartItems, $cartProducts)
	{
		$subtotalPrices = [];
		
		foreach($cartItems as $cartItemId => $cartItem)
		{
			if( $cartItem['item'] == 'kit' ) {
				$price = $cartProducts[$cartItem['productId']]['kitPrice'];
			} else {
				$price      = $cartProducts[$cartItem['productId']]['productItem'][$cartItem['item']]['price'];
				$pricePromo = $cartProducts[$cartItem['productId']]['productItem'][$cartItem['item']]['pricePromo'];

				$price = ( $pricePromo ) ? $pricePromo : $price;
			}

			$addonsPrice = $this->_inventoryPageData->countSingleAddonsTotalPrice($cartItem['addons']);
			
			$subtotalPrices[$cartItemId] = ($price + $addonsPrice) * $cartItem['quantity'];
		}
		
		return $subtotalPrices;
	}

    public function deleteCartItem($cartItems, $cartItemId)
    {
        if( empty($cartItems[$cartItemId]) )
            return $cartItems;

        unset($cartItems[$cartItemId]);

        return $cartItems;
    }

    public function clearCart()
    {
        if( $this->_session->has(self::SESSION_CART) ) {
            $this->_session->remove(self::SESSION_CART);
        }
    }
}