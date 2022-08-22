<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Question\Controller\ListQuestion;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package Tigren\Question\Controller\ListQuestion
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Session $customerSession
     */
    public function __construct(
        Context     $context,
        PageFactory $resultPageFactory,
        Session     $customerSession
    )
    {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        if ($this->customerSession->isLoggedIn()) {
            return $this->resultPageFactory->create();

        } else {
            return $this->_redirect('/');
        }
    }
}
