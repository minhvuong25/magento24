<?php
namespace Magento\Customer\Api\Data;

/**
 * Extension class for @see \Magento\Customer\Api\Data\GroupInterface
 */
class GroupExtension extends \Magento\Framework\Api\AbstractSimpleObject implements GroupExtensionInterface
{
    /**
     * @return int[]|null
     */
    public function getExcludeWebsiteIds()
    {
        return $this->_get('exclude_website_ids');
    }

    /**
     * @param int[] $excludeWebsiteIds
     * @return $this
     */
    public function setExcludeWebsiteIds($excludeWebsiteIds)
    {
        $this->setData('exclude_website_ids', $excludeWebsiteIds);
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsVisibleOnStorefront()
    {
        return $this->_get('is_visible_on_storefront');
    }

    /**
     * @param bool $isVisibleOnStorefront
     * @return $this
     */
    public function setIsVisibleOnStorefront($isVisibleOnStorefront)
    {
        $this->setData('is_visible_on_storefront', $isVisibleOnStorefront);
        return $this;
    }
}
