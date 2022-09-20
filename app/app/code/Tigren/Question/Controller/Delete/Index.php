<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Question\Controller\Delete;

use Exception;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Tigren\Question\Model\QuestionFactory;
use function Aws\boolean_value;

/**
 * Class Index
 * @package Tigren\Question\Controller\Delete
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $_pageFactory;
    /**
     * @var Http
     */
    protected $_request;
    /**
     * @var QuestionFactory
     */
    protected $_contactFactory;

    protected $checkoutSession;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param Http $request
     * @param QuestionFactory $contactFactory
     */
    public function __construct(
        Context         $context,
        PageFactory     $pageFactory,
        Http            $request,
        QuestionFactory $contactFactory,
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_request = $request;
        $this->_contactFactory = $contactFactory;
        return parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface
     * @throws Exception
     */
    public function execute()
    {
        $id = $this->_request->getParam('id');
        $postData = $this->_contactFactory->create()->load($id);
        $postData->getData('entity_id');
        //  $postData->delete();
        if ($postData->delete()) {
            $this->messageManager->addSuccessMessage('Delete Successfully');
        } else {
            $this->messageManager->addSuccessMessage("Delete Failed");
        }

        return $this->_redirect('question/listquestion/index');
    }
}
