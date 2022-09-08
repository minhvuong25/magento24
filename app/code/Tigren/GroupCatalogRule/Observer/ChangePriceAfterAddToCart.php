<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\GroupCatalogRule\Observer;

use Magento\Customer\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Tigren\GroupCatalogRule\Model\ResourceModel\Customer\CollectionFactory;

/**
 * Class ChangePriceAfterAddToCart
 * @package Tigren\GroupCatalogRule\Observer
 */
class ChangePriceAfterAddToCart implements ObserverInterface
{
    /**
     * @var Session
     */
    private $_customerSession;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Session $customerSession
     * @param CollectionFactory $collectionFactory
     */

    public function __construct(
        Session           $customerSession,
        CollectionFactory $collectionFactory
    )
    {
        $this->_customerSession = $customerSession;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return int|void
     */
    private function getGroupId()
    {
        if ($this->_customerSession->isLoggedIn()) {
            return $this->_customerSession->getCustomer()->getGroupId();
        }
    }

    /**
     * @param Observer $observer
     * @return void
     */

    public function execute(Observer $observer)
    {

        try {
            $quoteItem = $observer->getData('quote_item');
            $product = $observer->getData('product');
            $sku = $product->getSku();
            $customerGroupId = $this->getGroupId();
            $ruleCollection = $this->collectionFactory->create();
            $ruleCollection->addFieldToFilter('products', ['like' => '%' . $sku . '%'])
                ->addFieldToFilter('customer_group_id', ['like' => '%' . $customerGroupId . '%'])
                ->setOrder('priority', 'DESC');
            $rule = $ruleCollection->setPageSize(1)->getFirstItem();
            $discount = $rule->getDiscountAmount();

            $priceAfterDiscount = $product->getPrice() * (100 - $discount) / 100;
            $quoteItem->setCustomPrice($priceAfterDiscount);
            $quoteItem->setOriginalCustomPrice($priceAfterDiscount);

            //Enable super mode on the product.
            $quoteItem->getProduct()->setIsSuperMode(true);
            $quoteItem->save();
        } catch (\Exception $e) {

        }

    }
}
