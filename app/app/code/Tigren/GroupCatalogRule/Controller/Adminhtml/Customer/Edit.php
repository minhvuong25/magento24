<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\GroupCatalogRule\Controller\Adminhtml\Customer;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;

/**
 * Class Edit
 * @package Tigren\GroupCatalogRule\Controller\Adminhtml\Customer
 */
class Edit extends Action
{
    /**
     * @return ResponseInterface|ResultInterface|Page|Page&ResultInterface
     */

    public function execute()
    {
        $resultPages = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPages->getConfig()->getTitle()->prepend("Rule Edit");
        return $resultPages;
    }

}