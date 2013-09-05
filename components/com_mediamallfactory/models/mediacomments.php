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

JLoader::register('MediaMallFactoryFrontendModelAdminMessages', FactoryApplication::getInstance()->getPath('component_site').DS.'models'.DS.'adminmessages.php');

class MediaMallFactoryFrontendModelMediaComments extends MediaMallFactoryFrontendModelAdminMessages
{
  protected $media = null;

  public function getMedia()
  {
    if (is_null($this->media)) {
      $media_id = JFactory::getApplication()->input->get->getInt('media_id', 0);
      $user_id  = JFactory::getUser()->id;
      $table    = FactoryTable::getInstance('Media');

      $table->load(array('id' => $media_id, 'user_id' => $user_id));

      if ($media_id != $table->id) {
        throw new Exception(FactoryText::sprintf('mediacomments_media_not_found', $media_id), 404);
        return false;
      }

      $this->media = $table;
    }

    return $this->media;
  }

  public function getItems()
  {
    return parent::getItems('media', $this->getMedia()->id);
  }
}
