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

jimport('joomla.application.component.model');

class MediaMallFactoryFrontendModelProfile extends JModel
{
  protected $form_name = 'profile';

  public function getForm($loadData = true)
  {
		$model = JModel::getInstance('EditProfile', 'MediaMallFactoryFrontendModel');

    return $model->getForm($loadData);
  }

  protected function loadFormData()
  {
    $data = $this->getItem();

    return $data;
  }

  public function getItem()
  {
    $model = JModel::getInstance('EditProfile', 'MediaMallFactoryFrontendModel');

    return $model->getItem();
  }

  public function getUnread($type = null)
  {
    // Initialise variables.
    $dbo  = $this->getDbo();
    $user = JFactory::getUser();

    // Get unread admin messages.
    $query = $dbo->getQuery(true)
      ->select('COUNT(1) AS count, CONCAT('.$dbo->quote('admin_messages_').', m.type) AS type')
      ->from('#__mediamallfactory_admin_messages m')
      ->where('m.is_admin = ' . $dbo->quote(1))
      ->where('m.pending = ' . $dbo->quote(1))
      ->where('m.owner_id = ' . $dbo->quote($user->id))
      ->group('m.type');

    if (!is_null($type)) {
      $query->where('m.type = ' . $dbo->quote($type));
    }

    $messages = $dbo->setQuery($query)
      ->loadObjectList('type');

    // Get unread credits log.
    $query = $dbo->getQuery(true)
      ->select('COUNT(1) AS count, ' . $dbo->quote('credits_log') . ' AS type')
      ->from('#__mediamallfactory_log_credits l')
      ->where('l.user_id = ' . $dbo->quote($user->id))
      ->where('l.pending = ' . $dbo->quote(1));
    $credits_log = $dbo->setQuery($query)
      ->loadObjectList('type');

    // Get unread balance log.
    $query = $dbo->getQuery(true)
      ->select('COUNT(1) AS count, ' . $dbo->quote('balance_log') . ' AS type')
      ->from('#__mediamallfactory_log_balance l')
      ->where('l.user_id = ' . $dbo->quote($user->id))
      ->where('l.pending = ' . $dbo->quote(1));
    $balance_log = $dbo->setQuery($query)
      ->loadObjectList('type');

    // Get unread purchases
    $query = $dbo->getQuery(true)
      ->select('COUNT(1) AS count, IF(p.user_id = '.$dbo->quote($user->id).', "purchases", "sales") AS type')
      ->from('#__mediamallfactory_purchases p')
      ->where('(p.pending_buyer = ' . $dbo->quote(1) . ' AND p.user_id = ' . $dbo->quote($user->id) . ')', 'OR')
      ->where('(p.pending_seller = ' . $dbo->quote(1) . ' AND p.author_id = ' . $dbo->quote($user->id) . ')')
      ->group('type');
    $purchases = $dbo->setQuery($query)
      ->loadObjectList('type');

    // Get contacts user.
    $query = $dbo->getQuery(true)
      ->from('#__mediamallfactory_purchases p')
      ->where('p.user_id = ' . $query->quote($user->id))
      ->where('p.type = ' . $query->quote('contact'))
      ->group('p.user_id');
    $query->select('COUNT(m.id)')
      ->leftJoin('#__mediamallfactory_admin_messages m ON m.item_id = p.id AND m.type = ' . $query->quote('contact') . ' AND m.pending = ' . $query->quote(1) . ' AND m.user_id <>' . $query->quote($user->id));
    $contactsUser = $dbo->setQuery($query)
      ->loadResult();

    // Get contacts author
    $query = $dbo->getQuery(true)
      ->from('#__mediamallfactory_purchases p')
      ->where('p.author_id = ' . $query->quote($user->id))
      ->where('p.type = ' . $query->quote('contact'))
      ->group('p.author_id');
    $query->select('COUNT(m.id)')
      ->leftJoin('#__mediamallfactory_admin_messages m ON m.item_id = p.id AND m.type = ' . $query->quote('contact') . ' AND m.pending = ' . $query->quote(1) . ' AND is_admin = ' . $query->quote(0));
    $contactsAuthor = $dbo->setQuery($query)
      ->loadResult();

    $unread = array_merge(
      $messages,
      $credits_log,
      $balance_log,
      $purchases,
      array('contactsUser' => (object)array('count' => $contactsUser)),
      array('contactsAuthor' => (object)array('count' => $contactsAuthor))
    );

    return $unread;
  }

  public function getIsAuthor()
  {
    $authors = FactoryApplication::getInstance()->getParam('authors.global.author', array());

    return (boolean)array_intersect(JFactory::getUser()->groups, $authors);
  }

  public function getMediaCount($userId = null)
  {
    if (is_null($userId)) {
      $userId = JFactory::getUser()->id;
    }

    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('COUNT(1)')
      ->from('#__mediamallfactory_media m')
      ->where('m.user_id = ' . $dbo->quote($userId));

    return $dbo->setQuery($query)
      ->loadResult();
  }
}
