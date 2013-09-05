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

JFormHelper::loadFieldType('MediaMallFactoryFile');

class JFormFieldMediaMallFactoryThumbnail extends JFormFieldMediaMallFactoryFile
{
  public $type = 'MediaMallFactoryThumbnail';

  protected function getFileLink()
  {
    $id = JFactory::getApplication()->input->get->getInt('media_id', 0);
    if (!$id) {
      return '';
    }

    $table = JTable::getInstance('Media', 'MediaMallFactoryTable');
    if ($id) {
      $table->load($id);
    }

    if (empty($table->filename_thumbnail)) {
      return '';
    }

    $large = FactoryApplication::getInstance()->getParam('general.thumbnails.large_media_width', 128);

    $html = '<div style="margin-bottom: 10px;"><img src="'.$table->getThumbnailSource($large).'" /></div>';

    return $html;
  }
}
