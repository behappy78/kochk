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

class JHtmlFactory
{
  public static function link($url, $text, $type = 'view', $attribs = null)
	{
		if (is_array($attribs)) {
			$attribs = JArrayHelper::toString($attribs);
		}

    $url = call_user_func_array(array('FactoryRoute', $type), array($url));

		return '<a href="' . $url . '" ' . $attribs . '>' . $text . '</a>';
	}

  public static function stripText($text, $length = 30, $default = '')
  {
    if ('' == $text) {
      return FactoryText::_($default);
    }

    if (strlen($text) < $length) {
      return $text;
    }

    return substr($text, 0, $length) . '...';
  }

  public static function listFilter($name, $filters)
  {
    if (!isset($filters[$name])) {
      return false;
    }

    return JHtml::_(
      'select.genericlist',
      $filters[$name],
      'filter['.$name.']',
      'class="form_filter"',
      'value',
      'text',
      $filters['_values']->get($name)
    );
  }

  public static function beginForm($url, $method = 'GET')
  {
    $html = array();
    $app  = JFactory::getApplication();

    // Add the start form tag.
    $html[] = '<form action="'.$url.'" method="'.$method.'" id="adminForm" name="adminForm">';

    // Check if SEF it's not enabled.
    if (!$app->getCfg('sef', 0)) {
      $url = parse_url($url);
      parse_str($url['query'], $output);

      foreach ($output as $key => $value) {
        $html[] = '<input type="hidden" name="'.$key.'" value="'.$value.'"">';
      }
    }

    return implode("\n", $html);
  }

  public static function date($date, $format = 'ago')
  {
    if ('ago' == $format) {
      return self::formatDateAgo($date);
    }

    return JHtml::date($date, $format);
  }

  protected static function formatDateAgo($date)
  {
    $now  = JFactory::getDate('now');
		$diff = strtotime($now) - strtotime($date);

    if ($diff < 60) {
      $type = 'seconds';
    } elseif ($diff < 3600) {
      $diff = floor($diff / 60);
      $type = 'minutes';
    } elseif ($diff < 3600 * 24) {
      $diff = floor($diff / 3600);
      $type = 'hours';
    } elseif ($diff < 3600 * 24 * 30) {
      $diff = floor($diff / 3600 / 24);
      $type = 'days';
    } elseif ($diff < 3600 * 24 * 365) {
      $diff = floor($diff / 3600 / 24 / 30);
      $type = 'months';
    } else {
      $diff = floor($diff / 3600 / 24 / 365);
      $type = 'years';
    }

    $output = FactoryText::plural('time_ago_' . $type, $diff);

    return $output;
  }

  public static function field($field)
  {
    $html = array();

    switch ($field->type) {
      case 'List':
        if (method_exists($field, 'getValue')) {
          $html[] = $field->getValue();
        } else {
          $html[] = $field->value;
        }
        break;

      case 'Switch':
        $html[] =  $field->value ? JText::_('JENABLED') : JText::_('JDISABLED');
        break;

      default:
        $html[] = $field->value;
        break;
    }

    return implode("\n", $html);
  }

  public static function currency($value, $symbol = null)
  {
    if (is_null($symbol)) {
      $symbol = FactoryApplication::getInstance()->getParam('general.currency.symbol', '&#8364;');
    }

    return '<b>'.number_format($value, 2) . '</b> ' . $symbol;
  }

  public static function behavior($behavior)
  {
    $behavior = 'behavior'.$behavior;
    if (method_exists('JHtmlFactory', $behavior)) {
      self::$behavior();
    }
  }

  protected static function behaviorTooltip()
  {
    static $loaded = false;

    if (!$loaded) {
      $loaded = true;

      FactoryHtml::script('jquery.tipsy');
      FactoryHtml::script('jquery.tooltip');
      FactoryHtml::stylesheet('jquery.tipsy');
    }
  }

  protected static function behaviorDropDown()
  {
    static $loaded = false;

    if ($loaded) {
      return true;
    }

    FactoryHtml::script('jquery.dropdown');
    FactoryHtml::stylesheet('jquery.dropdown');

    $loaded = true;

    return true;
  }

  protected static function behaviorJQueryUI()
  {
    FactoryHtml::script('jquery', false);
    FactoryHtml::script('jquery-ui', false);
    FactoryHtml::script('jquery.noconflict', false);

    return true;
  }
}
