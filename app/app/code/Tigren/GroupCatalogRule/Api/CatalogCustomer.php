<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\GroupCatalogRule\Api;


/**
 * Class CatalogCustomer
 * @package Tigren\GroupCatalogRule\Api
 */
class CatalogCustomer
{

    /**
     * {@inheritdoc}
     */

    public function getPost($param)
    {
        return 'api GET return the $param ' . $param;
    }
}
