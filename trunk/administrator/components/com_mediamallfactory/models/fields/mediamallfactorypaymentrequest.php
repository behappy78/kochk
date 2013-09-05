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

class JFormFieldMediaMallFactoryPaymentRequest extends JFormField
{
  public $type = 'MediaMallFactoryPaymentRequest';

  protected function getInput()
  {
    $registry = new JRegistry($this->value);
    $html = array();

    $html[] = '<ul>';

    foreach ($registry->toArray() as $key => $value) {
      $html[] = '<li><u>'.$key.'</u>: '.$value.'</li>';
    }

    $html[] = '</ul>';

    return implode("\n", $html);
  }
}
