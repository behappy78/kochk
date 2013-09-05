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

class MediaMallFactoryFrontendModelHistoryPurchases extends JModelList
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

    $filters['state'] = array(
      ''         => FactoryText::_('historypurchases_filter_state_label'),
      'active'   => FactoryText::_('historypurchases_filter_state_active'),
      'inactive' => FactoryText::_('historypurchases_filter_state_inactive'),
    );

    $filters['sort'] = array(
      ''        => FactoryText::_('historypurchases_filter_sort_label'),
      'credits' => FactoryText::_('historypurchases_filter_sort_credits'),
    );

    $filters['dir'] = array(
      'asc' => FactoryText::_('list_filter_dir_asc'),
      ''    => FactoryText::_('list_filter_dir_desc'),
    );

    $this->sortFilters = array(
      ''        => 'p.created_at',
      'credits' => 'p.credits',
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

    $query->select('p.*')
      ->from('#__mediamallfactory_purchases p')
      ->where('p.user_id = ' . $query->quote($user->id));

    $query->select('m.title AS media_title')
      ->leftJoin('#__mediamallfactory_media m ON m.id = p.media_id');

    $this->addFilterStateCondition($query);
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

  protected function addFilterStateCondition($query)
  {
    $filter = $this->filterValues->get('state', '');

    if ('' != $filter) {
      if ('active' == $filter) {
        $query->where('p.active = ' . $query->quote(1));
      } else {
        $query->where('p.active = ' . $query->quote(0));
      }
    }
  }

  protected function markAsRead($items)
  {
    $array = array();

    foreach ($items as $item) {
      if ($item->pending_buyer) {
        $array[] = $item->id;
      }
    }

    if (!$array) {
      return true;
    }

    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->update('#__mediamallfactory_purchases')
      ->set('pending_buyer = ' . $dbo->quote(0))
      ->where('id IN ('.implode(',', $array).')');

    return $dbo->setQuery($query)
      ->query();
  }
}
