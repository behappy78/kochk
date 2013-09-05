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

class MediaMallFactoryFrontendModelHistoryBalance extends JModelList
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

    $filters['type'] = array(
      ''                 => FactoryText::_('historybalance_filter_type_label'),
      'media_sale_media' => FactoryText::_('historybalance_filter_type_media_sale_media'),
      'media_sale_archive' => FactoryText::_('historybalance_filter_type_media_sale_archive'),
      'media_sale_contact' => FactoryText::_('historybalance_filter_type_media_sale_contact'),
      'converted_funds'  => FactoryText::_('historybalance_filter_type_converted_funds'),
      'withdrawn_funds'  => FactoryText::_('historybalance_filter_type_withdrawn_funds'),
      'admin'            => FactoryText::_('historybalance_filter_type_admin'),
    );

    $filters['sort'] = array(
      ''       => FactoryText::_('historybalance_filter_sort_label'),
      'amount' => FactoryText::_('historybalance_filter_sort_amount'),
    );

    $filters['dir'] = array(
      'asc' => FactoryText::_('list_filter_dir_asc'),
      ''    => FactoryText::_('list_filter_dir_desc'),
    );

    $this->sortFilters = array(
      ''       => 'l.created_at',
      'amount' => 'l.amount',
    );

    $filters['_values'] = $this->filterValues;

    return $filters;
  }

  public function getItems()
  {
    $items = parent::getItems();

    $this->markAsRead($items);

    return $items;
  }

  protected function getListQuery()
	{
		$query = parent::getListQuery();
    $user  = JFactory::getUser();

    $query->select('l.*')
      ->from('#__mediamallfactory_log_balance l')
      ->where('l.user_id = ' . $query->quote($user->id));

    $query->select('m.title AS media_title')
      ->leftJoin('#__mediamallfactory_media m ON m.id = l.media_id');

    $this->addFilterTypeCondition($query);
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

  protected function addFilterTypeCondition($query)
  {
    $filter = $this->filterValues->get('type', '');

    if ('' != $filter) {
      $query->where('l.type = ' . $query->quote($filter));
    }
  }

  protected function markAsRead($items)
  {
    $array = array();

    foreach ($items as $item) {
      if ($item->pending) {
        $array[] = $item->id;
      }
    }

    if (!$array) {
      return true;
    }

    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->update('#__mediamallfactory_log_balance')
      ->set('pending = ' . $dbo->quote(0))
      ->where('id IN ('.implode(',', $array).')');

    return $dbo->setQuery($query)
      ->query();
  }
}
