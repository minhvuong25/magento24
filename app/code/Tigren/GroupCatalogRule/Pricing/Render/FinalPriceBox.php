<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\GroupCatalogRule\Pricing\Render;

use Magento\Catalog\Model\Product\Pricing\Renderer\SalableResolverInterface;
use Magento\Catalog\Pricing\Price\MinimalPriceCalculatorInterface;
use Magento\Framework\Pricing\Price\PriceInterface;
use Magento\Framework\Pricing\Render\RendererPool;
use Magento\Framework\Pricing\SaleableInterface;

/**
 * Class FinalPriceBox
 */
class FinalPriceBox extends \Magento\Catalog\Pricing\Render\FinalPriceBox
{

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param SaleableInterface $saleableItem
     * @param PriceInterface $price
     * @param RendererPool $rendererPool
     * @param array $data
     * @param SalableResolverInterface|null $salableResolver
     * @param MinimalPriceCalculatorInterface|null $minimalPriceCalculator
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        SaleableInterface                                $saleableItem,
        PriceInterface                                   $price,
        RendererPool                                     $rendererPool,
        array                                            $data = [],
        SalableResolverInterface                         $salableResolver = null,
        MinimalPriceCalculatorInterface                  $minimalPriceCalculator = null
    )
    {
        parent::__construct($context,
            $saleableItem,
            $price,
            $rendererPool,
            $data,
            $salableResolver,
            $minimalPriceCalculator);
    }

    /**
     * @param $html
     * @return string
     */
    protected function wrapResult($html)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $httpContext = $objectManager->get('Magento\Framework\App\Http\Context');
        $isLoggedIn = $httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);

        if ($isLoggedIn) {
            return '<div class="price-box price-final_price' . $this->getData('css_classes') . '" ' .
                'data-role="price-box" ' .
                'data-product-id="' . $this->getSaleableItem()->getId() . '"' .
                '>' . $html . '</div>';


        } else {
            $wording = 'Please Login To See Price';
            return '<div class="" ' .
                'data-role="price-box" ' .
                'data-product-id="' . $this->getSaleableItem()->getId() . '"' .
                '>' . $wording . '</div>';
        }
    }
}

