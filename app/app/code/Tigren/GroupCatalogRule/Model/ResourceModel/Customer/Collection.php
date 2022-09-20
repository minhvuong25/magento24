<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\GroupCatalogRule\Model\ResourceModel\Customer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class collection
 * @package Tigren\GroupCatalogRule\Model\ResourceModel\Customer
 */
class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Tigren\GroupCatalogRule\Model\Customer', 'Tigren\GroupCatalogRule\Model\ResourceModel\Customer');
    }
}
