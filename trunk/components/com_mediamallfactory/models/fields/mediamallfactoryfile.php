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

JFormHelper::loadFieldType('File');

class JFormFieldMediaMallFactoryFile extends JFormFieldFile
{
  public $type = 'MediaMallFactoryFile';

  protected function getInput()
  {
    FactoryHtml::stylesheet('fields/file');

    $html = array();

    $html[] = '<div>';
    $html[] = $this->getFileLink();
    $html[] = $this->_getInput();
    $html[] = $this->getAllowedExtensions();
    $html[] = '</div>';

    return implode("\n", $html);
  }

  protected function getFileLink()
  {
    $id = $this->form->getValue('id');

    if (!$id) {
      return '';
    }

    if ('archive' == (string)$this->element['filetype']) {
      $link = FactoryRoute::task('media.download&format=archive&media_id='.$id);
      $name = $this->form->getValue('filename_archive');
    } else {
      $link = FactoryRoute::task('media.download&media_id='.$id);
      $name = $this->form->getValue('filename_media');
    }

    return '<div class="mediamallfactoryfile-link"><a href="'.$link.'">'.$name.'</a></div>';
  }

  protected function getAllowedExtensions()
  {
    $extensions = (string)$this->element['extensions'];

    return '<div class="mediamallfactoryfile-extensions" '.('' == $extensions ? 'style="display:none;"' :'').'>'.$extensions.'</div>';
  }

  protected function _getInput()
	{
		// Initialize some field attributes.
		$accept = $this->element['accept'] ? ' accept="' . (string) $this->element['accept'] . '"' : '';
		$size = $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
		$class = $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
		$disabled = ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';
    $extensions = (string)$this->element['extensions'];
    $extensions = '' != $extensions ? ' extensions="'.$extensions.'"' : '';

		// Initialize JavaScript field attributes.
		$onchange = $this->element['onchange'] ? ' onchange="' . (string) $this->element['onchange'] . '"' : '';

		return '<input type="file" name="' . $this->name . '" id="' . $this->id . '"' . ' value=""' . $accept . $disabled . $class . $size
			. $onchange . $extensions . ' />';
	}
}
