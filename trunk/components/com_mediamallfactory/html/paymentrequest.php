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

class JHtmlMediaMallFactoryPaymentRequest
{
  public static function status($state)
  {
    $html = array();

    $classes = array(
      0  => 'warning',
      1  => 'success',
      2  => 'important',
    );

    $texts = array(
      0 => FactoryText::_('paymentrequest_status_pending'),
      1 => FactoryText::_('paymentrequest_status_released'),
      2 => FactoryText::_('paymentrequest_status_rejected'),
    );

    $html[] = '<span class="factory-label label-'.$classes[$state].'">';
    $html[] = $texts[$state];
    $html[] = '</span>';

    return implode("\n", $html);
  }
}
