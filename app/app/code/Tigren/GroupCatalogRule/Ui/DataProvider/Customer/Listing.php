<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Tigren\GroupCatalogRule\Ui\DataProvider\Customer;

use Tigren\GroupCatalogRule\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Framework\Api\Filter;
use Magento\Ui\DataProvider\AbstractDataProvider;


/**
 * Class Listing
 * @package Tigren\GroupCatalogRule\Ui\DataProvider\Customer
 */
class Listing extends AbstractDataProvider
{
    public function __construct(
        CollectionFactory $collectionFactory,
                          $name,
                          $primaryFieldName,
                          $requestFieldName,
        array             $meta = [],
        array             $data = []
    )
    {

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();

    }

    public function addFilter(Filter $filter)
    {
        if ($filter->getField() == 'rule_id') {
            $filter->setField('tigren_customer_group_catalog_rule' . $filter->getField());
        }
        parent::addFilter($filter);
    }
}
