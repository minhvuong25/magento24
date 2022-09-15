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
use Tigren\GroupCatalogRule\Model\OrderHistoryRuleFactory;

class ProductHistory implements ObserverInterface
{
    protected $customer_session;
    protected $collection;

    public function __construct(
        Session                         $customer_session,
        OrderHistoryRuleFactory         $modelHistory,
        \Magento\Checkout\Model\Session $checkoutsession
    )
    {
        $this->session = $customer_session;
        $this->modelHistory = $modelHistory;
        $this->checkoutsession = $checkoutsession;
    }


    public function execute(EventObserver $observer)
    {
        $order = $observer->getOrder();
        $orderId = $order->getId();
        $customerId = $order->getCustomerId();
        $productHistory = $this->modelHistory->create();
        $ruleId = $this->checkoutsession->getData('rule_id_product');
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        try {
            if (isset($ruleId)) {
                $data = [
                    'order_id' => $orderId,
                    'customer_id' => $customerId,
                    'rule_id' => $ruleId,
                ];
                $logger->info(print_r($data, true));
                $productHistory->addData($data);
                $productHistory->save();
            }
        } catch (\Exception $e) {

            $logger->info(print_r($e->getMessage(), true));
        }


    }
}
