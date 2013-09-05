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

JFormHelper::loadFieldType('Editor');

class JFormFieldMediaMallFactoryInvoiceTemplateEditor extends JFormFieldEditor
{
  public $type = 'MediaMallFactoryInvoiceTemplateEditor';

  protected function getLabel()
  {
    if ($this->element['nolabel'] != 'false') {
     return '';
    }

    return parent::getLabel();
  }

  protected function getInput()
  {
    FactoryHtml::script('admin/fields/editor');

    $html = array();

    $html[] = parent::getInput();
    $html[] = '<table class="mediamallfactoryeditor" style="float: left; clear: both; margin-top: 20px;" rel="'.$this->id.'">';

    $options = $this->getOptions();
    if ($options) {
      foreach ($this->getOptions() as $key => $text) {
        $html[] = '<tr><td width="120px">' . FactoryText::_($text) . '</td><td>-</td><td><a href="#" class="mediamallfactoryeditor-token">' . $key . '</a></td></tr>';
      }
    }

    $html[] = '</table>';

    return implode("\n", $html);
  }

  protected function getOptions()
  {
    $options = array();

    foreach ($this->element->option as $option) {
      $options[(string)$option->attributes()->value] = $option;
    }

    return $options;
  }
}
