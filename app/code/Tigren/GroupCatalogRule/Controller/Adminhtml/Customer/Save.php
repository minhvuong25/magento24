<?php

namespace Tigren\GroupCatalogRule\Controller\Adminhtml\Customer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Tigren\GroupCatalogRule\Model\CustomerFactory;

class Save extends Action
{
    public function __construct(
        CustomerFactory $customerFactory,
        Context         $context)
    {
        parent::__construct($context);
        $this->customerFactory = $customerFactory;
    }

    public function execute()
    {
        $rule = $this->getRequest()->getParams();
        $id = $rule['rule_id'];
        $name = $rule['name'];
        $products = $rule['products'];
        $discount_amount = $rule['discount_amount'];
        $priority = $rule['priority'];
        $is_active = $rule['is_active'];
        $from_date = $rule['from_date'];
        $to_date = $rule['to_date'];
        $store_id = $rule['store_id'];
        $customer_group_ids = $rule['customer_group_ids'][0];
        $form_key = $rule['form_key'];
        $rule = $this->customerFactory->create();
        $arr = [
            'name' => $name,
            'products' => $products,
            'discount_amount' => $discount_amount,
            'priority' => $priority,
            'is_active' => $is_active,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'store_id' => $store_id,
            'customer_group_ids' => $customer_group_ids,
            'form_key' => $form_key,
        ];
        if (isset($id)) {
            $rule->load($id);
            $rule->addData($arr);
            $rule->save();
            $this->messageManager->addSuccessMessage('completed edit');;
            return $this->_redirect('tigren_groupcatalogrule/customer/index');
        } else {
            $rule->addData($arr);
            $rule->save();
            $this->messageManager->addSuccessMessage('completed create');;
            return $this->_redirect('tigren_groupcatalogrule/customer/index');
        }
    }
}
