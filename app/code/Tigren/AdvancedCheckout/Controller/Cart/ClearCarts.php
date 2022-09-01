<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\AdvancedCheckout\Controller\Cart;

use Magento\Checkout\Model\Sidebar;
use Magento\Framework\App\Action\Action;
use Magento\Backend\App\Action\Context;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Quote\Model\Quote\Item;
use  Magento\Checkout\Model\Cart as CustomerCart;


/**
 * Class ClearCart
 * @package Tigren\AdvancedCheckout\Controller\Cart
 */
class ClearCarts extends Action
{
    protected $cart;

    protected $checkoutSession;

    public function __construct(
        Context         $context,
        CheckoutSession $checkoutSession,
        CustomerCart    $cart,
        Sidebar         $sidebar
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->cart = $cart;
        $this->sidebar = $sidebar;
        parent::__construct($context);
    }

    public function execute()
    {
        $all_item = $this->checkoutSession->getQuote()->getAllVisibleItems();
        foreach ($all_item as $item) {
            $item_id = $item->getItemId();
            $this->sidebar->removeQuoteItem($item_id);
            // $this->cart->removeItem($item_id)->save();
            //$this->cart->removeItem($item_id);
        }

        $message = __("You deleted all item from cart ");

        $this->messageManager->addErrorMessage($message);
        $response = [
            "success" => true
        ];
        $this->getResponse()->representJson(
            $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($response)
        );

    }
}
