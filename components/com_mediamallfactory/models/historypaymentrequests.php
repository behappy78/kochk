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

class MediaMallFactoryFrontendModelHistoryPaymentRequests extends JModelList
{
  protected $sortFilters = array();

  public function __construct($config = array())
  {
    parent::__construct($config);

    $this->filterValues = new JRegistry(JFactory::getApplication()->input->get('filter', 'GET', 'array'));

    $table = FactoryTable::getInstance('Profile');
    $table->load(JFactory::getUser()->id);

    JFactory::getApplication()->input->set('limit', $table->list_limit);
  }

  public function getFilters()
  {
    $filters = array();

    $filters['status'] = array(
      ''         => FactoryText::_('historypaymentrequests_filter_status_label'),
      'pending'  => FactoryText::_('historypaymentrequests_filter_status_pending'),
      'released' => FactoryText::_('historypaymentrequests_filter_status_released'),
      'rejected' => FactoryText::_('historypaymentrequests_filter_status_rejected'),
    );

    $filters['sort'] = array(
      ''       => FactoryText::_('historypaymentrequests_filter_sort_label'),
      'amount' => FactoryText::_('historypaymentrequests_filter_sort_amount'),
    );

    $filters['dir'] = array(
      'asc' => FactoryText::_('list_filter_dir_asc'),
      ''    => FactoryText::_('list_filter_dir_desc'),
    );

    $this->sortFilters = array(
      ''       => 'r.created_at',
      'amount' => 'r.amount',
    );

    $filters['_values'] = $this->filterValues;

    return $filters;
  }

  protected function getListQuery()
	{
		$query = parent::getListQuery();
    $user  = JFactory::getUser();

    $query->select('r.*')
      ->from('#__mediamallfactory_payment_requests r')
      ->where('r.user_id = ' . $query->quote($user->id))
      ->group('r.id');

    $query->select('COUNT(m.id) AS messages')
      ->leftJoin('#__mediamallfactory_admin_messages m ON m.type = '.$query->quote('payment_request').' AND m.item_id = r.id AND m.is_admin = ' . $query->quote(1) . ' AND m.pending = ' . $query->quote(1));

    $this->addFilterStatusCondition($query);
    $this->addOrder($query);

    return $query;
	}

  protected function addOrder($query)
  {
    $filter_sort = $this->filterValues->get('sort', '');
    $filter_dir  = $this->filterValues->get('dir', 'desc');
    $filter_sort = isset($this->sortFilters[$filter_sort]) ? $this->sortFilters[$filter_sort] : '';

    if ('' != $filter_sort) {
      $query->order($filter_sort . ' ' . $filter_dir);
    }
  }

  protected function addFilterStatusCondition($query)
  {
    $filter = $this->filterValues->get('status', '');

    if ('' != $filter) {
      if ('pending' == $filter){
        $query->where('r.status = ' . $query->quote(0));
      } elseif ('released' == $filter){
        $query->where('r.status = ' . $query->quote(1));
      } elseif ('rejected' == $filter){
        $query->where('r.status = ' . $query->quote(2));
      }
    }
  }
}
