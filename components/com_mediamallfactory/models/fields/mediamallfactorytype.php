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

JFormHelper::loadFieldType('list');

class JFormFieldMediaMallFactoryType extends JFormFieldList
{
  protected $type = 'MediaMallFactoryType';

  protected function getOptions()
  {
    FactoryHtml::script('fields/type');

    $dbo = JFactory::getDbo();
    $query = $dbo->getQuery(true)
      ->select('t.id AS value, t.title AS text, t.player')
      ->from('#__mediamallfactory_types t');

    $options = $dbo->setQuery($query)
      ->loadObjectList();

    $players = array();
    foreach ($options as $option) {
      if (!in_array($option->player, $players)) {
        $players[] = $option->player;
      }
    }

    jimport('joomla.filesystem.file');
    $extensions = array();
    foreach ($players as $player) {
      $path = FactoryApplication::getInstance()->getPath('players').DS.$player.DS.'config.xml';

      if (!JFile::exists($path)) {
        continue;
      }

      $xml = JFactory::getXML($path);
      $extensions[$player] = array();

      if ($xml->files) {
        foreach ($xml->files->children() as $file) {
          $extensions[$player][] = (string)$file->attributes()->extension;
        }
      }
    }

    $array = array();
    foreach ($options as $option) {
      $array[$option->value] = $extensions[$option->player];
    }

    $document = JFactory::getDocument();
    $document->addScriptDeclaration('Joomla._mediamallfactory_extensions = ' . json_encode($array) . ';');

    return $options;
  }

  protected function getInput()
	{
		// Initialize variables.
		$html = array();
		$attr = '';

		// Initialize some field attributes.
		$attr .= $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';

		// To avoid user's confusion, readonly="true" should imply disabled="true".
		if ((string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true')
		{
			$attr .= ' disabled="disabled"';
		}

		$attr .= $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
		$attr .= $this->multiple ? ' multiple="multiple"' : '';
    $attr .= $this->element['update'] ? ' rel="'.$this->formControl.'_'.(string)$this->element['update'].'"' : '';
		// Initialize JavaScript field attributes.
		$attr .= $this->element['onchange'] ? ' onchange="' . (string) $this->element['onchange'] . '"' : '';

		// Get the field options.
		$options = (array) $this->getOptions();

		// Create a read-only list (no name) with a hidden input to store the value.
		if ((string) $this->element['readonly'] == 'true')
		{
			$html[] = JHtml::_('select.genericlist', $options, '', trim($attr), 'value', 'text', $this->value, $this->id);
			$html[] = '<input type="hidden" name="' . $this->name . '" value="' . $this->value . '"/>';
		}
		// Create a regular list.
		else
		{
			$html[] = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
		}

		return implode($html);
	}
}
