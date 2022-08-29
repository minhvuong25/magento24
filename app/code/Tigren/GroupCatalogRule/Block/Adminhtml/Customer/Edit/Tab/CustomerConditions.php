<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\GroupCatalogRule\Block\Adminhtml\Customer\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Form\Renderer\Fieldset;
use Magento\Framework\Data\Form;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Rule\Block\Actions;
use Magento\Rule\Model\Condition\AbstractCondition;
use Magento\SalesRule\Model\Rule;
use Magento\Ui\Component\Layout\Tabs\TabInterface;


class CustomerConditions extends Generic implements
    TabInterface
{
    /**
     * Core registry
     *
     * @var Fieldset
     */
    protected $_rendererFieldset;

    /**
     * @var Actions
     */
    protected $_ruleActions;

    /**
     * @var string
     */
    protected $_nameInLayout = 'actions_apply_to';

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Actions $ruleActions
     * @param Fieldset $rendererFieldset
     * @param array $data
     */
    public function __construct(
        Context     $context,
        Registry    $registry,
        FormFactory $formFactory,
        Actions     $ruleActions,
        Fieldset    $rendererFieldset,
        array       $data = []
    )
    {
        $this->_rendererFieldset = $rendererFieldset;
        $this->_ruleActions = $ruleActions;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function getTabClass()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function getTabUrl()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function isAjaxLoaded()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function getTabLabel()
    {
        return __('Customer Conditions');
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function getTabTitle()
    {
        return __('Customer Conditions');
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry(RegistryConstants::CURRENT_GROUPCAT_RULE_ID);
        $form = $this->addTabToForm($model);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Handles addition of actions tab to supplied form.
     *
     * @param Rule $model
     * @param string $fieldsetId
     * @param string $formName
     * @return Form
     * @throws LocalizedException
     */
    protected function addTabToForm($model, $fieldsetId = 'actions_fieldset', $formName = 'amasty_groupcat_rule_form')
    {
        $actionsFieldSetId = $model->getActionsFieldSetId($formName);

        $newChildUrl = $this->getUrl(
            'amasty_groupcat/rule/newActionHtml/form/' . $actionsFieldSetId,
            ['form_namespace' => $formName]
        );

        /** @var Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('rule_')
            ->setCustomerConditionsTooltip(true);

        $renderer = $this->_rendererFieldset->setTemplate(
            'Amasty_Groupcat::rule/condition/fieldset.phtml'
        )->setNewChildUrl(
            $newChildUrl
        )->setFieldSetId(
            $actionsFieldSetId
        )->setNameInLayout(
            'amasty_rule_condition_fieldset'
        );

        $fieldset = $form->addFieldset(
            $fieldsetId,
            [
                'legend' => __('Conditions')
            ]
        )->setRenderer(
            $renderer
        );

        $fieldset->addField(
            'actions',
            'text',
            [
                'name' => 'apply_to',
                'label' => __('Apply To'),
                'title' => __('Apply To'),
                'required' => true,
                'data-form-part' => $formName
            ]
        )->setRule(
            $model
        )->setRenderer(
            $this->_ruleActions
        );

        $form->setValues($model->getData());
        $this->setActionFormName($model->getActions(), $formName);

        if ($model->isReadonly()) {
            foreach ($fieldset->getElements() as $element) {
                $element->setReadonly(true, true);
            }
        }

        return $form;
    }

    /**
     * Handles addition of form name to action and its actions.
     *
     * @param AbstractCondition $actions
     * @param string $formName
     * @return void
     */
    private function setActionFormName(AbstractCondition $actions, $formName)
    {
        $actions->setFormName($formName);
        if ($actions->getActions() && is_array($actions->getActions())) {
            foreach ($actions->getActions() as $condition) {
                $this->setActionFormName($condition, $formName);
            }
        }
    }
}
