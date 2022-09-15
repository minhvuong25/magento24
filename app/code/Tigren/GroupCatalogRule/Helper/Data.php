<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\GroupCatalogRule\Helper;


use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Tigren\GroupCatalogRule\Model\ResourceModel\Customer\CollectionFactory;

/**
 * Class Data
 * @package Tigren\GroupCatalogRule\Helper
 */
class Data extends AbstractHelper
{
    /**
     * @param Context $context
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param Session $customerSession
     * @param CollectionFactory $collection
     */
    public function __construct(
        Context                         $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        Session                         $customerSession,
        CollectionFactory               $collection
    )
    {
        parent::__construct($context);
        $this->custom_session = $customerSession;
        $this->session = $checkoutSession;
        $this->collection = $collection;
    }

    /**
     * @param $sku
     * @return mixed
     */
    public function show_discount($sku)
    {
        $ruleCollection = $this->collection->create();
        $customerGroupId = $this->custom_session->getCustomer()->getGroupId();
        $ruleCollection->addFieldToFilter('products', ['like' => '%' . $sku . '%'])
            ->addFieldToFilter('customer_group_id', ['like' => '%' . $customerGroupId . '%'])
            ->setOrder('priority', 'DESC');
        $ruleCustomer = $ruleCollection->setPageSize(1)->getFirstItem();
        $discount = $ruleCustomer->getDiscountAmount();
        return $discount;
    }

    /**
     * @return \Magento\Quote\Api\Data\CartInterface|\Magento\Quote\Model\Quote
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getcart()
    {
        return $this->session->getQuote();
    }
}
