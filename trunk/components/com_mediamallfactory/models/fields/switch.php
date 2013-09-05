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

defined('JPATH_BASE') or die;

JFormHelper::loadFieldType('Radio');

class JFormFieldSwitch extends JFormFieldRadio
{
	public $type = 'Switch';

  protected function getInput()
  {
    FactoryHtml::stylesheet('fields/switch');
    FactoryHtml::script('fields/switch', true);

    $html = array();
    $options = $this->getOptions();

    $html[] = '<p class="field switch">';

    foreach ($options as $option) {
      $checked  = ((string)$option->value == (string)$this->value) ? ' checked="checked"' : '';
      $selected	= ((string)$option->value == (string)$this->value) ? ' selected'          : '';

      $html[] = '<input type="radio" id="' . $this->id . $option->value . '" name="' . $this->name . '"  ' . $checked . ' value="'.htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8').'" />';
      $html[] = '<label for="' . $this->id . $option->value . '" class="switch-' . ($option->value ? 'enable' : 'disable') . ' ' . $selected . '"><span>' . $option->text . '</span></label>';
    }

    $html[] = '</p>';

    return implode("\n", $html);
  }

  protected function getOptions()
  {
    $options = parent::getOptions();

    if (!$options) {
      $options = array(
        new JObject(array('value' => 1, 'text' => JText::_('JENABLED'))),
        new JObject(array('value' => 0, 'text' => JText::_('JDISABLED'))),
      );
    }

    return $options;
  }
}
