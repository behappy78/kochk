<?php

/**------------------------------------------------------------------------
com_mediamallfactory - Media Mall Factory 3.3.5 
------------------------------------------------------------------------
 * @author TheFactory
 * @copyright Copyright (C) 2011 SKEPSIS Consult SRL. All Rights Reserved.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Websites: http://www.thefactory.ro
 * Technical Support: Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die;

JFormHelper::loadFieldType('List');

class JFormFieldMediaMallFactoryPaymentStatus extends JFormFieldList
{
  public $type = 'MediaMallFactoryPaymentStatus';

  protected function getInput()
  {
    if (in_array($this->value, array(20, 30))) {
      $this->element['readonly'] = 'true';
      $this->element['class']    = 'readonly';
    }

    return parent::getInput();
  }

  protected function getOptions()
  {
    return array(
      10 => FactoryText::_('field_payment_status_label_pending'),
      20 => FactoryText::_('field_payment_status_label_completed'),
      30 => FactoryText::_('field_payment_status_label_failed'),
      40 => FactoryText::_('field_payment_status_label_manual_check'),
    );
  }
}
