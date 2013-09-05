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

class JHtmlMediaMallFactory
{
  public static function date($date, $format = null)
  {
    if (is_null($format)) {
      $format = FactoryApplication::getInstance()->getParam('date', 'Y-m-d H:i:s');
    }

    return JHtml::_('Factory.date', $date, $format);
  }
}
