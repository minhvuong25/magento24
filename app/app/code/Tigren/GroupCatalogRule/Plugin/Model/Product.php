<?php

namespace Tigren\GroupCatalogRule\Plugin\Model;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Model\Context;
use PHPUnit\TextUI\Help;
use Tigren\GroupCatalogRule\Helper\Data;

class Product
{
    protected $customerSessionFactory;

    public function __construct(
        Session $customerSessionFactory
    )
    {
        $this->customerSessionFactory = $customerSessionFactory;
    }


    public function afterIsSaleable(\Magento\Catalog\Model\Product $subject)
    {
        if ($this->customerSessionFactory->isLoggedIn()) {
            return $subject->isSaleable();
        } else {
            return false;
        }
    }
}
