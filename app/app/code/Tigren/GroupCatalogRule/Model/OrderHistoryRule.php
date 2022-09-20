<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\GroupCatalogRule\Model;

use Magento\Framework\Model\AbstractModel;


/**
 * Class Product
 * @package Tigren\GroupCatalogRule\ModelHistory
 */
class OrderHistoryRule extends AbstractModel
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Tigren\GroupCatalogRule\Model\ResourceModel\OrderHistoryRule');
    }
}