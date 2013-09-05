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

class MediaMallFactoryFrontendModelMediaLog extends JModelList
{
  protected $sortFilters = array();

  public function __construct($config = array())
  {
    parent::__construct($config);

    $this->filterValues = new JRegistry(JFactory::getApplication()->input->get('filter', 'GET', 'array'));

//    $app = JFactory::getApplication();
//    $app->setUserState('global.list.limit', 1);
  }

  public function getItem($media_id = null)
  {
    static $items = array();

    if (is_null($media_id)) {
      $media_id = JFactory::getApplication()->input->getInt('media_id', 0);
    }

    if (!isset($items[$media_id])) {
      $table = FactoryTable::getInstance('Media');
      $table->load($media_id);

      if (JFactory::getUser()->id != $table->user_id) {
        throw new Exception(FactoryText::sprintf('medialog_media_not_found', $media_id), 404);
      }

      $items[$media_id] = $table;
    }

    return $items[$media_id];
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
    );

    $filters['dir'] = array(
      'asc' => FactoryText::_('list_filter_dir_asc'),
      ''    => FactoryText::_('list_filter_dir_desc'),
    );

    $this->sortFilters = array(
      ''       => 'l.created_at',
    );

    $filters['_values'] = $this->filterValues;

    return $filters;
  }

  protected function getListQuery()
	{
    $item  = $this->getItem();
		$query = parent::getListQuery();

    $query->select('l.*')
      ->from('#__mediamallfactory_media_log l')
      ->where('l.media_id = ' . $query->quote($item->id));

    // Select media title.
    $query->select('m.title')
      ->leftJoin('#__mediamallfactory_media m ON m.id = l.media_id');

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
