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

class MediaMallFactoryBackendModelDashboard extends JModel
{
  protected $limit;

  public function __construct($config = array())
  {
    parent::__construct($config);

    $this->limit = FactoryApplication::getInstance()->getParam('general.dashboard.limit', 5);
  }

  public function getNotifications()
  {
    $notfications = array(
      'pending_media'    => $this->getPendingMediaNotifications(),
      'media_messages'   => $this->getMediaMessagesNotifications(),
      'payment_messages' => $this->getPaymentMessagesNotifications(),
    );

    return $notfications;
  }

  public function getOrder()
  {
    $input = JFactory::getApplication()->input;
    $cookie = $input->get('mediamallfactory_dashboard_columns', '', 'string');

    $panels = array(
      'notifications',
      'latestmedia',
      'latestmediapending',
      'latestorders',
      'latestpayments',
      'latestpaymentrequests',
    );

    $array = array(
      'first'  => array(
        'notifications',
      ),
      'second' => array(
        'latestmedia',
        'latestmediapending',
        'latestorders',
        'latestpayments',
        'latestpaymentrequests',
      ),
    );

    if (false === strpos($cookie, '/')) {
      return $array;
    }

    list($first, $second) = explode('/', $cookie);
    $first  = trim($first, '.');
    $second = trim($second, '.');

    $first = '' == $first ? array() : explode('.', $first);
    $second = '' == $second ? array() : explode('.', $second);

    $merge = array_merge($first, $second);
    foreach ($panels as $panel) {
      if (!in_array($panel, $merge)) {
        $first[] = $panel;
      }
    }

    $array = array(
      'first' => $first,
      'second' => $second,
    );

    return $array;
  }

  public function getLatestMedia()
  {
    return $this->getLatestMediaQuery();
  }

  public function getLatestMediaPending()
  {
    return $this->getLatestMediaQuery(array('m.published' => -1));
  }

  public function getLatestOrders()
  {
    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('o.*')
      ->from('#__mediamallfactory_orders o')
      ->order('o.created_at DESC');

    // Select gateway.
//    $query->select('g.id AS gateway_id, g.title AS gateway_title')
//      ->leftJoin('#__mediamallfactory_payment_gateways g ON g.element = o.gateway');

    // Select username.
    $query->select('u.username')
      ->leftJoin('#__users u ON u.id = o.user_id');

    return $dbo->setQuery($query, 0, $this->limit)
      ->loadObjectList();
  }

  public function getLatestPayments()
  {
    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('p.*')
      ->from('#__mediamallfactory_payments p')
      ->order('p.created_at DESC');

    // Select gateway.
    $query->select('g.id AS gateway_id, g.title AS gateway_title')
      ->leftJoin('#__mediamallfactory_payment_gateways g ON g.element = p.gateway');

    // Select username.
//    $query->select('u.username')
//      ->leftJoin('#__users u ON u.id = p.user_id');

    return $dbo->setQuery($query, 0, $this->limit)
      ->loadObjectList();
  }

  public function getLatestPaymentRequests()
  {
    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('r.*')
      ->from('#__mediamallfactory_payment_requests r')
      ->order('r.created_at DESC');

    // Select username.
    $query->select('u.username')
      ->leftJoin('#__users u ON u.id = r.user_id');

    return $dbo->setQuery($query, 0, $this->limit)
      ->loadObjectList();
  }

  protected function getPendingMediaNotifications()
  {
    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('COUNT(1)')
      ->from('#__mediamallfactory_media m')
      ->where('m.published = ' . $dbo->quote(-1));

    return $dbo->setQuery($query)
      ->loadResult();
  }

  protected function getMediaMessagesNotifications()
  {
    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('COUNT(1)')
      ->from('#__mediamallfactory_admin_messages m')
      ->where('m.type = ' . $dbo->quote('media'))
      ->where('m.is_admin = ' . $dbo->quote(0))
      ->where('m.pending = ' . $dbo->quote(1));

    return $dbo->setQuery($query)
      ->loadResult();
  }

  protected function getPaymentMessagesNotifications()
  {
    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('COUNT(1)')
      ->from('#__mediamallfactory_admin_messages m')
      ->where('m.type = ' . $dbo->quote('payment_request'))
      ->where('m.is_admin = ' . $dbo->quote(0))
      ->where('m.pending = ' . $dbo->quote(1));

    return $dbo->setQuery($query)
      ->loadResult();
  }

  protected function getLatestMediaQuery($conditions = array())
  {
    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('m.*')
      ->from('#__mediamallfactory_media m')
      ->order('m.created_at DESC');

    // Select username.
    $query->select('u.username')
      ->leftJoin('#__users u ON u.id = m.user_id');

    // Select category.
    $query->select('c.title AS category_title')
      ->leftJoin('#__categories c ON c.id = m.category_id');

    // Select type.
    $query->select('t.title AS type_title')
      ->leftJoin('#__mediamallfactory_types t ON t.id = m.type_id');

    foreach ($conditions as $column => $value) {
      $query->where($dbo->nameQuote($column) . ' = ' . $dbo->quote($value));
    }

    return $dbo->setQuery($query, 0, $this->limit)
      ->loadObjectList();
  }
}
