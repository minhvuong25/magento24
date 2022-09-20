<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Question\Controller\Save;

use Exception;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Tigren\Question\Model\QuestionFactory;

/**
 * Class Index
 * @package Tigren\Question\Controller\Save
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $_pageFactory;

    /**
     * @var QuestionFactory
     */
    protected $_questionFactory;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param QuestionFactory $questionFactory
     */
    public function __construct(
        Context         $context,
        PageFactory     $pageFactory,
        QuestionFactory $questionFactory,
        Session         $customerSession,
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_questionFactory = $questionFactory;
        $this->_customerSession = $customerSession;
        return parent::__construct($context);
    }

    /**
     * @return ResponseInterface
     */
    public function execute()
    {
        try {
            $data = (array)$this->getRequest()->getPost();
            $newData = [
                'title' => $data['title'],
                'content' => $data['content'],
                'author_id' => $this->_customerSession->getCustomer()->getId(),
            ];

            if (!empty($newData)) {
                $model = $this->_questionFactory->create();
                $model->setData($newData)->save();
                $this->messageManager->addSuccessMessage(__("Data Created Successfully."));
            }
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $this->_redirect('question/listquestion/index');
    }
}
