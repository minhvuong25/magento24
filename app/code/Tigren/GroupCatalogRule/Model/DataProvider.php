<?php

namespace Tigren\GroupCatalogRule\Model;


use Magento\Ui\DataProvider\AbstractDataProvider;
use Tigren\GroupCatalogRule\Model\ResourceModel\Customer\CollectionFactory;

/**
 * Class DataProvider
 * @package Tigren\Question\Model\Config
 */
class DataProvider extends AbstractDataProvider
{

    protected $_loadedData;

    protected $collection;


    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $this->_loadedData[$item->getId()] = $item->getData();
        }
        return $this->_loadedData;
    }
}
