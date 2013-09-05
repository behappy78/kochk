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

class MediaMallFactoryFrontendModelContacts extends MediaMallFactoryFrontendModelAdminMessages
{
  protected $media    = null;
  protected $purchase = null;

  public function getPurchase()
  {
    if (is_null($this->purchase)) {
      $user  = JFactory::getUser();
      $id    = JFactory::getApplication()->input->get->getInt('contact_id', 0);
      $table = FactoryTable::getInstance('Purchase');

      // Load purchase.
      $table->load($id);

      // Check if user is author or buyer.
      if ($table->user_id != $user->id && $table->author_id != $user->id) {
        throw new Exception(FactoryText::sprintf('contact_not_allowed', $id), 403);
        return false;
      }

      $this->purchase = $table;
    }

    return $this->purchase;
  }

  public function getMedia()
  {
    if (is_null($this->media)) {
      $table    = FactoryTable::getInstance('Media');
      $media_id = $this->getPurchase()->media_id;

      if (!$table->load($media_id)) {
        throw new Exception(FactoryText::sprintf('contact_media_not_found', $media_id), 404);
      }

      $this->media = $table;
    }

    return $this->media;
  }

  public function getItems()
  {
    return parent::getItems('contact', $this->getPurchase()->id);
  }

  protected function markAsRead($items, $is_admin = false)
  {
    $user  = JFactory::getUser();
    $array = array();
    foreach ($items as $item) {
      if ($item->pending && $user->id != $item->user_id) {
        $array[] = $item->id;
      }
    }

    if (!$array) {
      return true;
    }

    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->update('#__mediamallfactory_admin_messages')
      ->set('pending = ' . $dbo->quote(0))
      ->where('id IN ('.implode(',', $array).')');

    return $dbo->setQuery($query)
      ->query();
  }
}
