<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\AdvancedCheckout\Controller\Cart;

use Magento\Catalog\Model\Product;
use Magento\Checkout\Model\Cart;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Exception\LocalizedException;
use Zend_Log;
use Zend_Log_Writer_Stream;

/**
 * Class AddToCart
 * @package Tigren\AdvancedCheckout\Controller\Cart
 */
class AddToCart extends Action
{
    /**
     * @var
     */
    protected $sku;
    /**
     * @var Cart
     */
    protected $cart;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @param Context $context
     * @param FormKey $formKey
     * @param Cart $cart
     * @param Product $product
     */
    public function __construct(
        Context $context,
        Formkey $formKey,
        Cart    $cart,
        Product $product
    )
    {
        $this->formKey = $formKey;
        $this->cart = $cart;
        $this->product = $product;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     * @throws LocalizedException
     */
    public function execute()
    {
        $qty = $this->getRequest()->getParam('qty');
        $productID = $this->getRequest()->getParam('productId');
        $param = array(
            'form_key' => $this->formKey->getFormKey(),
            'qty' => $qty,
            'product' => $productID
        );

        $product = $this->product->load($productID);
        $this->cart->addProduct($product, $param);
        $this->cart->save();

        $message = __("Product add success");
        $this->messageManager->addSuccessMessage($message);
        $response = [
            "success" => true
        ];
        $this->getResponse()->representJson(
            $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($response)
        );
    }
}
