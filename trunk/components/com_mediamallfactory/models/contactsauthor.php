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

class MediaMallFactoryFrontendModelContactsAuthor extends JModelList
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

    $filters['sort'] = array(
      '' => FactoryText::_('contactsuser_filter_sort_label'),
    );

    $filters['dir'] = array(
      'asc' => FactoryText::_('list_filter_dir_asc'),
      ''    => FactoryText::_('list_filter_dir_desc'),
    );

    $this->sortFilters = array(
      '' => 'p.created_at',
    );

    $filters['_values'] = $this->filterValues;

    return $filters;
  }

  protected function getListQuery()
	{
		$query = parent::getListQuery();
    $user  = JFactory::getUser();

    $query->select('p.*')
      ->from('#__mediamallfactory_purchases p')
      ->where('p.author_id = ' . $query->quote($user->id))
      ->where('p.type = ' . $query->quote('contact'))
      ->group('p.id');

    // Select pending messages.
    $query->select('COUNT(m.id) AS pending')
      ->leftJoin('#__mediamallfactory_admin_messages m ON m.item_id = p.id AND m.type = ' . $query->quote('contact') . ' AND m.pending = ' . $query->quote(1) . ' AND m.user_id <>' . $query->quote($user->id));

    // Select media title
    $query->select('md.title AS media_title')
      ->leftJoin('#__mediamallfactory_media md ON md.id = p.media_id');

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
}
