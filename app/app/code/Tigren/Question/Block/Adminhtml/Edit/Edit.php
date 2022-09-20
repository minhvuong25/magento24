<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Quesiton\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Phrase;
use Magento\Framework\Registry;

/**
 * Class Edit
 * @package Tigren\Quesiton\Block\Adminhtml\Edit
 */
class Edit extends Container
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry = null;

//    /**
//     * @param Context $context
//     * @param Registry $registry
//     * @param array $data
//     */
//    public function __construct(
//        Context  $context,
//        Registry $registry,
//        array    $data = []
//    )
//    {
//        $this->_coreRegistry = $registry;
//        parent::__construct($context, $data);
//    }

    /**
     * Department edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'entity_id';
        $this->_blockGroup = 'Tigren_Question';
        $this->_controller = 'adminhtml_question';

        parent::_construct();

        if ($this->_isAllowedAction('Tigren_Question::question_save')) {
            $this->buttonList->update('save', 'label', __('Save Question'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                        ],
                    ]
                ],
                -100
            );
        } else {
            $this->buttonList->remove('save');
        }

    }

    /**
     * Get header with Department name
     *
     * @return Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('tigren_question')->getId()) {
            return __("Edit Quesiton '%1'", $this->escapeHtml($this->_coreRegistry->registry('tigren_question')->getName()));
        } else {
            return __('New Question');
        }
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('question/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }
}
