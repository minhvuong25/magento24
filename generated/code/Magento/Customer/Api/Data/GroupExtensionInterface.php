<?php
namespace Magento\Customer\Api\Data;

/**
 * ExtensionInterface class for @see \Magento\Customer\Api\Data\GroupInterface
 */
interface GroupExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * @return int[]|null
     */
    public function getExcludeWebsiteIds();

    /**
     * @param int[] $excludeWebsiteIds
     * @return $this
     */
    public function setExcludeWebsiteIds($excludeWebsiteIds);

    /**
     * @return bool|null
     */
    public function getIsVisibleOnStorefront();

    /**
     * @param bool $isVisibleOnStorefront
     * @return $this
     */
    public function setIsVisibleOnStorefront($isVisibleOnStorefront);
}
