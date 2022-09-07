<?php

namespace Tigren\Question\Controller\Adminhtml\Question;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Tigren\Question\Model\QuestionFactory;
use function PHPUnit\Framework\isEmpty;

class Save extends Action
{
    public function __construct(
        Context         $context,
        QuestionFactory $questionFactory
    )
    {
        parent::__construct($context);
        $this->_questionFactory = $questionFactory;
    }

    public function execute()
    {
//        $param = $this->getRequest()->getParams()['entity_id'];
//        $id = $param['entity_id'];
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
