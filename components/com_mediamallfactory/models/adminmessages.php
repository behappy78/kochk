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

abstract class MediaMallFactoryFrontendModelAdminMessages extends JModel
{
  public function getItems($type = null, $item_id = null)
  {
    $dbo = $this->getDbo();

    $query = $dbo->getQuery(true)
      ->select('m.*')
      ->from('#__mediamallfactory_admin_messages m')
      ->order('m.created_at DESC');

    if (!is_null($type)) {
      $query->where('m.type = ' . $dbo->quote($type));
    }

    if (!is_null($item_id)) {
      $query->where('m.item_id = ' . $dbo->quote($item_id));
    }

    $query->select('u.username')
      ->leftJoin('#__users u ON u.id = m.user_id');

    $items = $dbo->setQuery($query)
      ->loadObjectList();

    $this->markAsRead($items);

    return $items;
  }

  public function getForm()
  {
    $model = JModel::getInstance('AdminMessage', 'MediaMallFactoryFrontendModel');

    return $model->getForm();
  }

  protected function markAsRead($items, $is_admin = false)
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
