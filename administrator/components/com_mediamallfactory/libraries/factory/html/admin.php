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

class JHtmlFactoryAdmin
{
  public static function sort($title, $order, $state)
  {
    $app     = JFactory::getApplication();
    $option  = $app->input->getCmd('option', '');
    $view    = $app->input->getCmd('view', 'list');
    $context = $option.'.'.$view.'.filters.sort';

    $values = $app->getUserState($context, array());

    if (!in_array($order, $values)) {
      $values[] = $order;
      $app->setUserState($context, $values);
    }

    return JHtml::_('grid.sort', FactoryText::_($title), $order, $state->get('list.direction'), $state->get('list.ordering'));
  }

  public static function order($items, $controller, $state)
  {
    if ('ordering' != $state->get('list.ordering')) {
      return '';
    }

    return JHtml::_('grid.order',  $items, 'filesave.png', $controller.'.saveorder');
  }

  public static function itemOrder($i, $ordering, $controller, $state, $pagination)
  {
    if ('ordering' != $state->get('list.ordering')) {
      return $ordering;
    }

    $html = array();

    if ('asc' == $state->get('list.direction')) {
      $html[] = '<span>' . $pagination->orderUpIcon($i, true, $controller.'.orderup', 'JLIB_HTML_MOVE_UP', true) . '</span>';
      $html[] = '<span>' . $pagination->orderDownIcon($i, $pagination->total, true, $controller.'.orderdown', 'JLIB_HTML_MOVE_DOWN', true) . '</span>';
    } else {
      $html[] = '<span>' . $pagination->orderUpIcon($i, true, $controller.'.orderdown', 'JLIB_HTML_MOVE_UP', true) . '</span>';
      $html[] = '<span>' . $pagination->orderDownIcon($i, $pagination->total, true, $controller.'.orderup', 'JLIB_HTML_MOVE_DOWN', true) . '</span>';
    }

    $html[] = '<input type="text" name="order[]" size="5" value="' . $ordering . '" class="text-area-order" />';

    return implode("\n", $html);
  }

  public static function nl2p($string)
  {
    $html = '<p>'.preg_replace('#(<br\s*?/?>\s*?){2,}#', '</p><p>', nl2br($string)).'</p>';

    return $html;
  }
}
