<?php

namespace Tigren\Customer\Setup;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Config;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class InstallData implements DataPatchInterface
{
    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var ModuleDataSetupInterface
     */
    private $setup;

    /**
     * @var Config
     */
    private $eavConfig;

    /**
     * AccountPurposeCustomerAttribute constructor.
     *
     * @param ModuleDataSetupInterface $setup
     * @param CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $setup,
        Config                   $eavConfig,
        CustomerSetupFactory     $customerSetupFactory
    )
    {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->setup = $setup;
        $this->eavConfig = $eavConfig;
    }

    /** We'll add our customer attribute here */
    public function apply()
    {
        $customerSetup
            = $this->customerSetupFactory->create(['setup' => $this->setup]);
        $customerEntity = $customerSetup->getEavConfig()
            ->getEntityType(Customer::ENTITY);
        $attributeSetId
            = $customerSetup->getDefaultAttributeSetId($customerEntity->getEntityTypeId());
        $attributeGroup
            = $customerSetup->getDefaultAttributeGroupId(
            $customerEntity->getEntityTypeId(),
            $attributeSetId
        );
        $customerSetup->addAttribute(Customer::ENTITY, 'is_question_created', [
            'type' => 'int',
            'input' => 'select',
            'label' => 'New Attribute',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => true,
            'default' => 0,
            'visible' => true,
            'user_defined' => true,
            'system' => false,
            'is_visible_in_grid' => true,
            'is_used_in_grid' => true,
            'is_filterable_in_grid' => true,
            'is_searchable_in_grid' => true,
            'position' => 300,
        ]);
        $newAttribute = $this->eavConfig->getAttribute(
            Customer::ENTITY,
            'is_question_created'
        );
        $newAttribute->addData([
            'used_in_forms' => [
                'admin_create',
                'admin_edit',
                'customer_create',
                'customer_edot',
            ],
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroup,
        ]);
        $newAttribute->save();
    }


    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}
