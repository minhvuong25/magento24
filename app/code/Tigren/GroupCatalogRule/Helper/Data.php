<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
 * @package Customer Group Catalog for Magento 2
 */

namespace Tigren\GroupCatalogRule\Helper;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Helper\Context;
use Tigren\GroupCatalogRule\Model\ResourceModel\Customer\CollectionFactory;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    public function __construct(
        Context                         $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Customer\Model\Session $customerSession,
        CollectionFactory               $collection
    )
    {
        parent::__construct($context);
        $this->custom_session = $customerSession;
        $this->session = $checkoutSession;
        $this->collection = $collection;
    }

    public function show_discount($sku)
    {
        $rule = $this->collection->creat();
        $id_customer = $this->custom_session->getId();
        $id_rule_customer = $this->collection->getCustomerGroupId();
        $discount = 0;
        if ($id_customer == $id_rule_customer) {
            $rule->addFieldToFilter('products', ['like' => '%' . $sku . '%'])
                ->addFieldToFilter('customer_group_id', ['like' => '%' . $id_rule_customer . '%'])
                ->setOrder('priority', 'DESC');
            $rule_customer = $rule->setPageSize(1)->getFirstItem();
            $discount = $rule->getDiscountAmount();
        }
        return $discount;
    }

    public function getcart()
    {
        return $this->session->getQuote();
    }
}
