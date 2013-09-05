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

class JHtmlMediaMallFactoryOrders
{
  public static function paid($state)
  {
    $states = array(
      0  => 'icon-16-disabled',
      1  => 'icon-16-checkin',
    );

    $html = array();

    $html[] = '<span class="jgrid"><span class="state '.$states[$state].'">';
    $html[] = '</span></span>';

    return implode("\n", $html);
  }

  public function status($state)
  {
    $states = array(
      10  => 'warning',
      20  => 'publish',
      30  => 'unpublish',
      40  => 'published',
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
      10  => 'warning',
      20  => 'success',
      30  => 'important',
      40  => 'info',
    );

    $texts = array(
      10 => FactoryText::_('order_status_pending'),
      20 => FactoryText::_('order_status_completed'),
      30 => FactoryText::_('order_status_failed'),
      40 => FactoryText::_('order_status_manual_check'),
    );

    $html[] = '<span class="factory-label label-'.$classes[$state].'">';
    $html[] = $texts[$state];
    $html[] = '</span>';

    return implode("\n", $html);
  }
}
