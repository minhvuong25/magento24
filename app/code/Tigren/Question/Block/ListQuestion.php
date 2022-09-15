<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Question\Block;

use Magento\Customer\Model\Session;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Element\Template;
use Tigren\Question\Model\ResourceModel\Question\Collection;
use Tigren\Question\Model\ResourceModel\Question\CollectionFactory;

/**
 * Class ListQuestion
 * @package Tigren\Question\Block
 */
class ListQuestion extends Template
{

    /**
     * @var CollectionFactory
     */
    public $collection;
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param Session $customerSession
     * @param array $data
     */
    public function __construct(
        Context           $context,
        CollectionFactory $collectionFactory,
        Session           $customerSession,
        array             $data = [])
    {
        $this->customerSession = $customerSession;
        $this->collection = $collectionFactory;
        parent::__construct($context, $data);

    }

    /**
     * @return Collection
     */
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
