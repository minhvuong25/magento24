<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Tigren\GroupCatalogRule\Observer;

use Magento\Catalog\Model\Product\Exception;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Customer\Model\Session;
use Tigren\GroupCatalogRule\ModelHistory\ProductFactory;
use Tigren\GroupCatalogRule\Model\ResourceModel\Customer\CollectionFactory;

class ProductHistory implements ObserverInterface
{
    protected $customer_session;
    protected $collection;

    public function __construct(
        Session                                              $customer_session,
        CollectionFactory                                    $collection,
        \Tigren\GroupCatalogRule\ModelHistory\ProductFactory $modelHistory,
        \Magento\Checkout\Model\Session                      $checkoutsession,

    )
    {
        $this->collection = $collection;
        $this->session = $customer_session;
        $this->modelHistory = $modelHistory;
        $this->checkoutsession = $checkoutsession;
    }


    public function execute(EventObserver $observer)
    {
        $order = $observer->getOrder();
        $order_id = $order->getId();
        $customer_id = $order->getCustomerId();
        $product_history = $this->modelHistory->create();
        $rule_id = $this->checkoutsession->getData('rule_id_product');
        if (isset($rule_id)) {
            $ar = [
                'order_id' => $order_id,
                'customer_id' => $customer_id,
                'rule_id' => $rule_id,
            ];
            $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
            $logger = new \Zend_Log();
            $logger->addWriter($writer);
            $logger->info(print_r($ar, true));
            $product_history->addData($ar);
            $product_history->save();
        }


    }
}
