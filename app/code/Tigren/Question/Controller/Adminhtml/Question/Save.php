<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Question\Controller\Adminhtml\Question;

use Exception;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Tigren\Question\Model\QuestionFactory;
use function PHPUnit\Framework\isEmpty;

/**
 * Class Save
 * @package Tigren\Question\Controller\Adminhtml\Question
 */
class Save extends Action
{
    /**
     * @param Context $context
     * @param QuestionFactory $questionFactory
     */
    public function __construct(
        Context         $context,
        QuestionFactory $questionFactory
    )
    {
        parent::__construct($context);
        $this->_questionFactory = $questionFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface
     * @throws Exception
     */
    public function execute()
    {
        $title = $this->getRequest()->getParam('title');
        $content = $this->getRequest()->getParam('content');
        $arr = [
            'title' => $title,
            'content' => $content,
        ];
        $question_add = $this->_questionFactory->create();

        if (isset($this->getRequest()->getParams()['entity_id'])) {
            $id = $this->getRequest()->getParams()['entity_id'];
            $model = $this->_questionFactory->create();
            $model->load($id);
            $model->addData($arr);
            $model->save();
            $this->messageManager->addSuccessMessage('completed edit');
            return $this->_redirect('tigren_question/question/index');
        } else {
            $question_add->addData($arr);
            $question_add->save();

            $this->messageManager->addSuccessMessage('completed create');
            return $this->_redirect('tigren_question/question/index');
        }

    }
}
