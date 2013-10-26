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

class MediaMallFactoryFrontendModelList extends JModelList
{
  protected $sortFilters = array();

  public function __construct($config = array())
  {
    parent::__construct($config);

    $this->filterValues = new JRegistry(JFactory::getApplication()->input->get('filter', 'GET', 'array'));

    $table = FactoryTable::getInstance('Profile');
    $table->load(JFactory::getUser()->id);

    JFactory::getApplication()->input->set('limit', $table->media_list_limit);
  }

  public function getItems()
  {
    $items = parent::getItems();

    foreach ($items as &$item) {
      $table = JTable::getInstance('Media', 'MediaMallFactoryTable');
      $table->bind($item);

      $item->thumbnail = $table->getThumbnailSource($this->getThumbnailWidth());
    }

    return $items;
  }

  public function getThumbnailWidth()
  {
    return FactoryApplication::getInstance()->getParam('general.thumbnails.small_media_width', 64);
  }

  public function getFilters()
  {
    $filters = array();

    $filters['category'] = $this->getCategoryFilter();
    $filters['type']     = $this->getTypeFilter();

    $filters['cost'] = array(
      ''     => FactoryText::_('list_filter_cost_label'),
      'free' => FactoryText::_('list_filter_cost_free'),
      'paid' => FactoryText::_('list_filter_cost_paid'),
    );

    $filters['archive'] = array(
      ''     => FactoryText::_('list_filter_archive_label'),
      'true' => FactoryText::_('list_filter_archive_true'),
      'false' => FactoryText::_('list_filter_archive_false'),
    );

    $filters['sort'] = array(
      ''        => FactoryText::_('list_filter_sort_label'),
      'rating'  => FactoryText::_('list_filter_sort_rating'),
      'reviews' => FactoryText::_('list_filter_sort_reviews'),
      'date'    => FactoryText::_('list_filter_sort_date'),
    );

    $filters['dir'] = array(
      ''     => FactoryText::_('list_filter_dir_asc'),
      'desc' => FactoryText::_('list_filter_dir_desc'),
    );

    $this->sortFilters = array(
      ''        => 'm.title',
      'rating'  => 'm.rating',
      'reviews' => 'm.votes',
      'date'    => 'm.created_at',
    );

    $filters['_values'] = $this->filterValues;

    return $filters;
  }

  protected function getListQuery()
	{
    /* @var $table MediaMallFactoryTableMedia */
    $table = JTable::getInstance('Media', 'MediaMallFactoryTable');
		$query = parent::getListQuery();
    $user  = JFactory::getUser();

    $query->select('m.*')
      ->from('#__mediamallfactory_media m');

    // Select the category.
    $query->select('c.title AS category_title')
      ->leftJoin('#__mediamallfactory_category c ON c.id = m.category_id')
      ->where('c.published = ' . $query->quote(1));

    // Select the username.
    $query->select('u.username')
      ->leftJoin('#__users u ON u.id = m.user_id');

    // Select the type.
    $query->select('t.title AS type_title')
      ->leftJoin('#__mediamallfactory_types t ON t.id = m.type_id')
      ->where('t.published = ' . $query->quote(1));

    $query->select('IF(m.user_id = ' . $query->quote($user->id) . ', 1, 0) AS is_owner');

    // Filter by published.
    $table->addMediaIsPublishedCondition($query);

    // Add filters.
    $this->addFilterCostCondition($query);
    $this->addFilterCategoryCondition($query);
    $this->addFilterArchiveCondition($query);
    $this->addFilterUsernameCondition($query);
    $this->addFilterTypeCondition($query);

    // Order.
    $this->addOrder($query);

    return $query;
	}

  protected function addFilterCostCondition($query)
  {
    $filter_cost = $this->filterValues->get('cost', '');

    if ('' != $filter_cost) {
      if ('free' == $filter_cost) {
        $query->where('((m.has_media = ' . $query->quote(1) . ' AND m.cost_media = ' . $query->quote(0) . ') OR (m.has_archive = ' . $query->quote(1) . ' AND m.cost_archive = ' . $query->quote(0) . '))');
      } else {
        $query->where('(IF (m.has_media = 0, 1, m.cost_media > 0) AND IF (m.has_archive = 0, 1, m.cost_archive > 0))');
      }
    }
  }

  protected function addFilterCategoryCondition($query)
  {
    $filter = $this->filterValues->get('category', 0);

    if ($filter) {
      $query->where('m.category_id = ' . $query->quote($filter));
    }
  }

  protected function addFilterArchiveCondition($query)
  {
    $filter = $this->filterValues->get('archive', '');

    if ('' != $filter) {
      if ('true' == $filter) {
        $query->where('m.has_archive = ' . $query->quote(1));
      } else {
        $query->where('m.has_archive = ' . $query->quote(0));
      }
    }
  }

  protected function addFilterTypeCondition($query)
  {
    $filter = $this->filterValues->get('type', '');

    if ('' != $filter) {
      $query->where('m.type_id = ' . $query->quote($filter));
    }
  }

  protected function addFilterUsernameCondition($query)
  {
    $filter = $this->filterValues->get('user', '');

    if ('' != $filter) {
      $query->where('u.username = ' . $query->quote($filter));
    }
  }

  protected function addOrder($query)
  {
    $filter_sort = $this->filterValues->get('sort', '');
    $filter_dir  = $this->filterValues->get('dir', 'asc');
    $filter_sort = isset($this->sortFilters[$filter_sort]) ? $this->sortFilters[$filter_sort] : '';

    if ('' != $filter_sort) {
      $query->order($filter_sort . ' ' . $filter_dir);
    }
  }

  protected function getCategoryFilter()
  {
    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('t.id AS value, t.title AS text')
      ->from('#__mediamallfactory_category t')
      ->order('t.title ASC');
    $results = $dbo->setQuery($query)
      ->loadObjectList();

    array_unshift($results, array('value' => '', 'text' => FactoryText::_('list_filter_category_label')));

    return $results;
   /*   
    $array = array('' => FactoryText::_('list_filter_category_label'));

    foreach (JHtml::_('category.options', 'com_mediamallfactory') as $category) {
      $array[$category->value] = $category->text;
    }

    return $array;*/
  }

  protected function getTypeFilter()
  {
    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('t.id AS value, t.title AS text')
      ->from('#__mediamallfactory_types t')
      ->order('t.title ASC');
    $results = $dbo->setQuery($query)
      ->loadObjectList();

    array_unshift($results, array('value' => '', 'text' => FactoryText::_('list_filter_type_label')));

    return $results;
  }
}
