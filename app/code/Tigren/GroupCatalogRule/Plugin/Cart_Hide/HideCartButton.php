<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\GroupCatalogRule\Plugin\Cart_Hide;

use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Session;

/**
 * Class Hidecartbutton
 * @package Tigren\GroupCatalogRule\Plugin\Cart_Hide
 */
class HideCartButton
{
    /**
     * @var Session
     */
    protected $_customerSessionFactory;


    /**
     * @param Session $customerSessionFactory
     */
    public function __construct(
        Session $customerSessionFactory,
    )
    {
        $this->_customerSessionFactory = $customerSessionFactory;
    }

    /**
     * @param Product $product
     * @param $isSaleable
     * @return bool
     */
    public function afterIsSaleable(Product $product, $isSaleable)
    {

        if ($this->_customerSessionFactory->isLoggedIn()) {
            return $product->isSalable();
        } else {
            return 0;
        }
    }
}
