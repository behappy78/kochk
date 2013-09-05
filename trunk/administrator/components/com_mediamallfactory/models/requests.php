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

class MediaMallFactoryBackendModelRequests extends FactoryModelAdminList
{
  protected $filters      = array('search', 'messages', 'status');
  protected $default_sort = array('created_at', 'desc');

  public function getFilterStatus()
  {
    return array(
      0 => FactoryText::_('requests_filter_status_pending_label'),
      1 => FactoryText::_('requests_filter_status_released_label'),
      2 => FactoryText::_('requests_filter_status_rejected_label'),
    );
  }

  public function getFilterMessages()
  {
    return array(
      0 => FactoryText::_('requests_list_filter_no_new_messages_label'),
      1 => FactoryText::_('requests_list_filter_new_messages_label'),
    );
  }

  protected function getQuery()
  {
    $query = parent::getQuery();

    // Select requests.
    $query->select('p.*')
      ->from('#__mediamallfactory_payment_requests p')
      ->group('p.id');

    // Select username.
    $query->select('u.username')
      ->leftJoin('#__users u ON u.id = p.user_id');

    // Select messages.
    $query->select('COUNT(am.id) AS messages')
      ->leftJoin('#__mediamallfactory_admin_messages am ON am.item_id = p.id AND am.type = '.$query->quote('payment_request').' AND am.is_admin = ' . $query->quote(0) . ' AND am.pending = ' . $query->quote(1));

    return $query;
  }

  protected function addFilterSearchCondition($query)
  {
    $filter = $this->getState('filter.search');

    if ('' != $filter) {
      $filter = $query->quote('%' . $filter . '%');
      $query->where('(u.username LIKE '.$filter.')');
    }
  }

  protected function addFilterStatusCondition($query)
  {
    $filter = $this->getState('filter.status');

    if ('' != $filter) {
      $query->where('p.status = ' . $query->quote($filter));
    }
  }

  protected function addFilterMessagesCondition($query)
  {
    $filter = $this->getState('filter.messages');

    if ('' != $filter) {
      if ($filter) {
        $query->having('messages > ' . $query->quote(0));
      } else {
        $query->having('messages = ' . $query->quote(0));
      }
    }
  }
}
