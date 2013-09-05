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

class JFormRuleMediaMallFactoryFile extends JFormRule
{
  public function test(&$element, $value, $group = null, &$input = null, &$form = null)
	{
    // Check if any file was uploaded.
    if (is_null($value)) {
      return true;
    }

    $label = $element['label'] ? JText::_($element['label']) : JText::_($element['name']);

    // Check for errors on the upload.
    if (0 != $value->error) {
      $element['message'] = FactoryText::sprintf('rule_file_error_upload', $label, $value->error);

      return false;
    }

    // Check for extensions restrictions
    if ('' != $extensions = (string)$element['extensions']) {
      jimport('joomla.filesystem.file');

      $extensions = explode(',', $extensions);

      foreach ($extensions as &$extension) {
        $extension = trim(strtolower($extension));
      }

      $current = strtolower(JFile::getExt($value->name));
      if (!in_array($current, $extensions)) {
        $element['message'] = FactoryText::sprintf('rule_file_error_extension_not_allowed', $label, $current);
        return false;
      }
    }

    return true;
  }
}
