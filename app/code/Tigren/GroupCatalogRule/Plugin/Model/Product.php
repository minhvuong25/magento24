<?php

namespace Tigren\GroupCatalogRule\Plugin\Model;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Model\Context;
use PHPUnit\TextUI\Help;
use Tigren\GroupCatalogRule\Helper\Data;

class Product
{

    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
//        $price_product = $subject->getPrice();
//        $discount = $this->helper->show_discount($subject->getSku());
//        $price_after_discount = $price_product - ($price_product * $discount) / 100;
//        return $price_after_discount;
        $result += 10;
        return $result;
    }
}
