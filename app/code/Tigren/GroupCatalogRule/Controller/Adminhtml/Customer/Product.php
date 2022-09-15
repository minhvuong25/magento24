<?php

namespace Tigren\GroupCatalogRule\Controller\Adminhtml\Customer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;


class Product extends Action
{
    /**
     * @var
     */
    protected $resultFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context     $context,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}

