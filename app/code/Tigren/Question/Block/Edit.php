<?php

namespace Tigren\Question\Block;

use Magento\Framework\View\Element\Template;

class Edit extends Template
{
    protected $_pageFactory;
    protected $_coreRegistry;
    protected $_contactLoader;
    protected $_request;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\View\Result\PageFactory       $pageFactory,
        \Magento\Framework\Registry                      $coreRegistry,
        \Tigren\Question\Model\QuestionFactory           $contactLoader,
        array                                            $data = []
    )
    {
        
        $this->_pageFactory = $pageFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_contactLoader = $contactLoader;
        return parent::__construct($context, $data);

    }

    public function execute()
    {
        return $this->_pageFactory->create();
    }

    public function getEditData()
    {
        $id = $this->_coreRegistry->registry('editId');
        $postData = $this->_contactLoader->create();
        $result = $postData->load($id);
        $result = $result->getData();
        return $result;

    }
}
