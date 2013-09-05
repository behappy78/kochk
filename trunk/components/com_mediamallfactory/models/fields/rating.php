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

class JFormFieldRating extends JFormField
{
  public function getInput()
  {
    JLoader::register('JHtmlMediaMallFactoryMedia', FactoryApplication::getInstance()->getPath('component').DS.'html'.DS.'media.php');

    FactoryHtml::script('fields/rating');

    $html = array();

    $html[] = JHtml::_('MediaMallFactoryMedia.simpleRating', $this->value);
    $html[] = '<input type="hidden" class="rating-star" name="' . $this->name . '" id="' . $this->id . '" value="'.$this->value.'" />';

    return implode("\n", $html);
  }
}

class JFormRuleRating extends JFormRule
{
  public function test(&$element, $value, $group = null, &$input = null, &$form = null)
	{
    if (!in_array(intval($value), array(1,2,3,4,5), true)) {
      return false;
    }

		return true;
  }
}
