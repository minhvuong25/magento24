<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\AdvancedCheckout\Controller\Ajax;


use Exception;
use Magento\Catalog\Model\ProductRepository;
use Magento\Checkout\Model\Cart;
use Magento\Checkout\Model\Session;
use Magento\Checkout\Model\Sidebar;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Json\Helper\Data;
use Magento\Quote\Model\Quote;
use Psr\Log\LoggerInterface;

/**
 * Class Index
 * @package Tigren\AdvancedCheckout\Controller\Ajax
 */
class Index extends Action
{

    /**
     * @var
     */
    protected $_chekoutsession;
    /**
     * @var ProductRepository
     */
    protected $_productRepository;
    /**
     * @var Sidebar
     */
    protected $sidebar;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Data
     */
    protected $jsonHelper;

    /**
     * @var Cart
     */
    protected $cart;

    /*
     * @param Context $context
     * @param Sidebar $sidebar
     * @param LoggerInterface $logger
     * @param Data $jsonHelper
     * @codeCoverageIgnore
     */
    /**
     * @param Context $context
     * @param Cart $cart
     * @param Sidebar $sidebar
     * @param LoggerInterface $logger
     * @param Data $jsonHelper
     * @param ProductRepository $productRepository
     */
    public function __construct(
        Context           $context,
        Cart              $cart,
        Sidebar           $sidebar,
        LoggerInterface   $logger,
        Data              $jsonHelper,
        ProductRepository $productRepository,
        Session           $_chekoutsession
    )
    {
        $this->sidebar = $sidebar;
        $this->logger = $logger;
        $this->jsonHelper = $jsonHelper;
        $this->cart = $cart;
        $this->_productRepository = $productRepository;
        parent::__construct($context);
    }

    /**
     * @return $this
     */
    public function execute()
    {
        $isShowPopup = false;
        $sku = $this->getRequest()->getParam('sku');

        try {

            $items = $this->getQuote()->getAllVisibleItems();
            $product = $this->_productRepository->get($sku);
            foreach ($items as $item) {
                if ($product->getSku() == $item->getProduct()->getSku() && $product->getCustomAttributes("allow_multi_order") == 0) {
                    $isShowPopup = true;
                }
            }
        } catch (Exception $e) {
            $this->logger->critical($e);
        }
        return $this->jsonResponse(['isShowPopup' => $isShowPopup]);

    }

    /**
     * @return Quote
     */
    private function getQuote()
    {
        return $this->cart->getQuote();

    }


    /**
     * @param $response
     * @return mixed
     */
    private function jsonResponse($response)
    {
        return $this->getResponse()->representJson(
            $this->jsonHelper->jsonEncode($response)
        );
    }
}
