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

class MediaMallFactoryFrontendModelMediaStats extends JModelList
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
      ''            => FactoryText::_('mediastats_filter_state_label'),
      'published'   => FactoryText::_('mediastats_filter_state_published'),
      'pending'     => FactoryText::_('mediastats_filter_state_pending'),
      'unpublished' => FactoryText::_('mediastats_filter_state_unpublished'),
    );

    $filters['sort'] = array(
      ''       => FactoryText::_('mediastats_filter_sort_label'),
      'amount' => FactoryText::_('mediastats_filter_sort_amount'),
      'sales'  => FactoryText::_('mediastats_filter_sort_sales'),
      'title'  => FactoryText::_('mediastats_filter_sort_title'),
    );

    $filters['dir'] = array(
      'asc' => FactoryText::_('list_filter_dir_asc'),
      ''    => FactoryText::_('list_filter_dir_desc'),
    );

    $this->sortFilters = array(
      ''       => 'm.created_at',
      'amount' => 'amount',
      'sales'  => 'sales',
      'title'  => 'm.title',
    );

    $filters['_values'] = $this->filterValues;

    return $filters;
  }

  public function getEditOwnMedia()
  {
    $user = JFactory::getUser();
    $restricted = FactoryApplication::getInstance()->getParam('authors.restrictions.edit_own_media', array());

    return array_intersect($user->groups, $restricted);
  }

  protected function getListQuery()
	{
		$query = parent::getListQuery();
    $user  = JFactory::getUser();

    $query->select('m.*')
      ->from('#__mediamallfactory_media m')
      ->where('m.user_id = ' . $query->quote($user->id))
      ->group('m.id');

    $query->select('SUM(p.amount) AS amount, COUNT(p.id) AS sales')
      ->leftJoin('#__mediamallfactory_purchases p ON p.media_id = m.id');

    $query->select('t.title AS type')
      ->leftJoin('#__mediamallfactory_types t ON t.id = m.type_id');

    $query->select('COUNT(am.id) AS unread')
      ->leftJoin('#__mediamallfactory_admin_messages am ON am.item_id = m.id AND am.type = ' . $query->quote('media') . ' AND am.pending = ' . $query->quote(1) . ' AND am.is_admin = ' . $query->quote(1));

    $this->addFilterStateCondition($query);
    $this->addOrder($query);

    return $query;
	}

  protected function addFilterStateCondition($query)
  {
    $filter = $this->filterValues->get('state', '');

    if ('' != $filter) {
      if ('pending' == $filter) {
        $query->where('m.published = ' . $query->quote(-1));
      } elseif ('unpublished' == $filter) {
        $query->where('m.published = ' . $query->quote(0));
      } else {
        $query->where('m.published = ' . $query->quote(1));
      }
    }
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
}
