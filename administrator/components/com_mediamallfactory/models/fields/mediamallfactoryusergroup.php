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

JFormHelper::loadFieldType('UserGroup');

class JFormFieldMediaMallFactoryUserGroup extends JFormFieldUsergroup
{
  public $type = 'MediaMallFactoryUserGroup';

  protected function getInput()
  {
    $name = substr($this->name, 0, strlen($this->name) - 2);
    $html = array();

    $html[] = '<input type="hidden" name="' . $name . '"' . ' value="" />';
    $html[] = parent::getInput();

    return implode("\n", $html);
  }
}
