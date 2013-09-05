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

class JFormFieldMediaMallFactoryPaymentErrors extends JFormField
{
  public $type = 'MediaMallFactoryPaymentErrors';

  protected function getInput()
  {
    $registry = new JRegistry($this->value);
    $errors = $registry->toArray();

    if (!$errors) {
      return '<p>'.FactoryText::_('field_payment_errors_no_errors').'</p>';
    }

    $html = array();
    $html[] = '<ul>';

    foreach ($errors as $error) {
      $html[] = '<li>'.$error.'</li>';
    }

    $html[] = '</ul>';

    return implode("\n", $html);
  }
}
