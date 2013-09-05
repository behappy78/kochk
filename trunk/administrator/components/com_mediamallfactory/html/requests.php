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

class JHtmlMediaMallFactoryRequests
{
  public static function status($state)
  {
    $states = array(
      0 => 'pending',
      1 => 'publish',
      2 => 'unpublish',
    );

    $html = array();

    $html[] = '<span class="jgrid"><span class="state '.$states[$state].'">';
    $html[] = '</span></span>';

    return implode("\n", $html);
  }

  public function statusBadge($state)
  {
    $html = array();

    $classes = array(
      0  => 'warning',
      1  => 'success',
      2  => 'important',
    );

    $texts = array(
      0 => FactoryText::_('order_status_pending'),
      1 => FactoryText::_('order_status_completed'),
      2 => FactoryText::_('order_status_failed'),
      3 => FactoryText::_('order_status_manual_check'),
    );

    $html[] = '<span class="factory-label label-'.$classes[$state].'">';
    $html[] = $texts[$state];
    $html[] = '</span>';

    return implode("\n", $html);
  }
}
