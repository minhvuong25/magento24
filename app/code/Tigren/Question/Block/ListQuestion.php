<?php

namespace Tigren\Question\Block;

use Magento\Customer\Model\Session;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Element\Template;
use Tigren\Question\Model\ResourceModel\Question\CollectionFactory;

class ListQuestion extends Template
{

    public $collection;
    protected $customerSession;

    public function __construct(
        Context           $context,
        CollectionFactory $collectionFactory,
        array             $data = [],
        Session           $customerSession)
    {
        $this->customerSession = $customerSession;
        $this->collection = $collectionFactory;
        parent::__construct($context, $data);

    }

    public function getCollection()
    {

        $author = '';
        if ($this->customerSession->isLoggedIn()) {
            $author = $this->customerSession->getCustomerId();

        }
        $collection = $this->collection->create();
        $collection->addFieldToFilter('author_id', $author);
        return $collection;
    }


}
