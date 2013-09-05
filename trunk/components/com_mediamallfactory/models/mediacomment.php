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

JLoader::register('MediaMallFactoryFrontendModelAdminMessage', FactoryApplication::getInstance()->getPath('component_site').DS.'models'.DS.'adminmessage.php');

class MediaMallFactoryFrontendModelMediaComment extends MediaMallFactoryFrontendModelAdminMessage
{
  protected function allowSave($data)
  {
    // Check if the request exists and belongs to the user.
    $table = FactoryTable::getInstance('Media');
    $table->load(array('id' => $data['item_id'], 'user_id' => $data['user_id']));

    if ($data['item_id'] != $table->id) {
      $this->setError(FactoryText::sprintf('mediacomment_save_error_media_not_found', $data['item_id']));
      return false;
    }

    return true;
  }

  protected function prepareData(&$data)
  {
    $data['owner_id'] = $data['user_id'];
  }
}
