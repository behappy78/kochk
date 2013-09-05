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

class MediaMallFactoryBackendModelOrders extends FactoryModelAdminList
{
  protected $filters      = array('search', 'gateway', 'paid', 'state');
  protected $default_sort = array('created_at', 'desc');

  public function __construct($config = array())
  {
    parent::__construct($config);

    $this->discover();
  }

  public function getFilterGateway()
  {
    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('g.element AS value, g.title AS text')
      ->from('#__mediamallfactory_payment_gateways g')
      ->order('g.title ASC');
    return $dbo->setQuery($query)
      ->loadObjectList();
  }

  public function getFilterPaid()
  {
    return array(
      1 => FactoryText::_('orders_filter_paid_paid_label'),
      0 => FactoryText::_('orders_filter_paid_not_paid_label'),
    );
  }

  public function getFilterState()
  {
    return array(
      10 => FactoryText::_('orders_filter_state_pending_label'),
      20 => FactoryText::_('orders_filter_state_completed_label'),
      30 => FactoryText::_('orders_filter_state_failed_label'),
      40 => FactoryText::_('orders_filter_state_manual_check_label'),
    );
  }

  protected function getQuery()
  {
    $query = parent::getQuery();
    $table = FactoryTable::getInstance('Order');

    // Select order.
    $query->select('o.*')
      ->from($query->quoteName($table->getTableName()) . ' o');

    // Select gateway.
    $query->select('g.title AS gateway_title')
      ->leftJoin('#__mediamallfactory_payment_gateways g ON g.element = o.gateway');

    // Select username.
    $query->select('u.username')
      ->leftJoin('#__users u ON u.id = o.user_id');

    return $query;
  }

  protected function addFilterSearchCondition($query)
  {
    $filter = $this->getState('filter.search');

    if ('' != $filter) {
      $filter = $query->quote('%' . $filter . '%');
      $query->where('o.title LIKE '.$filter);
    }
  }

  protected function addFilterGatewayCondition($query)
  {
    $filter = $this->getState('filter.gateway');

    if ('' != $filter) {
      $query->where('g.element = ' . $query->quote($filter));
    }
  }

  protected function addFilterPaidCondition($query)
  {
    $filter = $this->getState('filter.paid');

    if ('' != $filter) {
      $query->where('o.paid = ' . $query->quote($filter));
    }
  }

  protected function addFilterStateCondition($query)
  {
    $filter = $this->getState('filter.state');

    if ('' != $filter) {
      $query->where('o.status = ' . $query->quote($filter));
    }
  }

  protected function discover()
  {
    $dbo = $this->getDbo();
    $table = FactoryTable::getInstance('PaymentGateway');

    $query = $dbo->getQuery(true)
      ->select('g.element')
      ->from($dbo->nameQuote($table->getTableName()) . ' g');
    $results = $dbo->setQuery($query)
      ->loadResultArray();

    jimport('joomla.filesystem.folder');
    $files = JFolder::folders(FactoryApplication::getInstance()->getPath('payment_gateways'));

    $new = 0;

    foreach (array_diff(array_merge($results, $files), array_intersect($results, $files)) as $different) {
      if (!in_array($different, $results)) {
        // Add to database.
        $table = FactoryTable::getInstance('PaymentGateway');

        $table->element = $different;
        $table->title   = $different;

        if ($table->store()) {
          $new++;
        }
      } else {
        // Remove from database.
        $query = $dbo->getQuery(true)
          ->delete()
          ->from($dbo->nameQuote($table->getTableName()))
          ->where('element = ' . $dbo->quote($different));
        $dbo->setQuery($query)
          ->query();
      }
    }

    if ($new) {
      JFactory::getApplication()->enqueueMessage(FactoryText::plural('gateways_added_new_gateways', $new), 'notice');
    }

    return true;
  }
}
