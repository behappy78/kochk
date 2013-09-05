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

class JFormFieldMediaMallFactoryCategoryThumbnail extends JFormField
{
  public $type = 'MediaMallFactoryCategoryThumbnail';

  protected function getInput()
  {
    $base = JURI::root().'components/com_mediamallfactory/storage/thumbnails/';

    $html = array();
    $html[] = '<img src="' . $base . $this->value . '" alt="-" />';
    $html[] = '<input type="hidden" name="' . $this->name . '" id="' . $this->id . '"' . ' value="' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '" />';

    return implode("\n", $html);
  }
}
