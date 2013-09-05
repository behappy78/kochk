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

class MediaMallFactoryBackendModelAdminMessages extends JModel
{
  public function getItems($type, $item_id)
  {
    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('m.*')
      ->from('#__mediamallfactory_admin_messages m')
      ->where('m.type = ' . $dbo->quote($type))
      ->where('m.item_id = ' . $dbo->quote($item_id))
      ->order('m.created_at DESC');

    $query->select('u.username')
      ->leftJoin('#__users u ON u.id = m.user_id');

    $items = $dbo->setQuery($query)
      ->loadObjectList();

    $this->markAsRead($items);

    return $items;
  }

  protected function markAsRead($items, $is_admin = true)
  {
    $array = array();
    foreach ($items as $item) {
      if ($item->pending && (int)!$is_admin == $item->is_admin) {
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
