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

class MediaMallFactoryBackendModelPayments extends FactoryModelAdminList
{
  protected $filters      = array('search', 'gateway', 'state');
  protected $default_sort = array('created_at', 'desc');

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
    $table = FactoryTable::getInstance('Payment');

    // Select order.
    $query->select('p.*')
      ->from($query->quoteName($table->getTableName()) . ' p');

    // Select gateway.
    $query->select('g.title AS gateway_title')
      ->leftJoin('#__mediamallfactory_payment_gateways g ON g.element = p.gateway');

    // Select username.
    $query->select('u.username')
      ->leftJoin('#__users u ON u.id = p.user_id');

    return $query;
  }

  protected function addFilterSearchCondition($query)
  {
    $filter = $this->getState('filter.search');

    if ('' != $filter) {
      $filter = $query->quote('%' . $filter . '%');
      $query->where('p.refnumber LIKE '.$filter);
    }
  }

  protected function addFilterGatewayCondition($query)
  {
    $filter = $this->getState('filter.gateway');

    if ('' != $filter) {
      $query->where('p.gateway = ' . $query->quote($filter));
    }
  }

  protected function addFilterStateCondition($query)
  {
    $filter = $this->getState('filter.state');

    if ('' != $filter) {
      $query->where('p.status = ' . $query->quote($filter));
    }
  }
}
