<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
 * @package Customer Group Catalog for Magento 2
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
