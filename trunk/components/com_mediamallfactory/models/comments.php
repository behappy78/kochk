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

jimport('joomla.application.component.modellist');

class MediaMallFactoryFrontendModelComments extends JModelList
{
  protected $sortFilters = array();
  protected $media_id;

  public function __construct($config = array())
  {
    parent::__construct($config);

    $this->filterValues = new JRegistry(JFactory::getApplication()->input->get('filter', 'GET', 'array'));
    $this->media_id     = $config['media_id'];

    $app = JFactory::getApplication();
    $app->setUserState('global.list.limit', 5);
  }

  public function getMedia()
  {
    return $this->media_id;
  }

  public function getFilters()
  {
    $filters = array();

    $filters['rating'] = array(
      '' => FactoryText::_('comments_filter_rating_label'),
      '5' => FactoryText::_('comments_filter_rating_5'),
      '4' => FactoryText::_('comments_filter_rating_4'),
      '3' => FactoryText::_('comments_filter_rating_3'),
      '2' => FactoryText::_('comments_filter_rating_2'),
      '1' => FactoryText::_('comments_filter_rating_1'),
    );

    $filters['sort'] = array(
      ''        => FactoryText::_('comments_filter_sort_label'),
      'rating'  => FactoryText::_('comments_filter_sort_rating'),
    );

    $filters['dir'] = array(
      ''    => FactoryText::_('list_filter_dir_desc'),
      'asc' => FactoryText::_('list_filter_dir_asc'),
    );

    $this->sortFilters = array(
      ''        => 'r.created_at',
      'rating'  => 'r.rating',
    );

    $filters['_values'] = $this->filterValues;

    return $filters;
  }

  protected function getListQuery()
	{
		$query = parent::getListQuery();

    $query->select('r.*')
      ->from('#__mediamallfactory_comments r')
      ->where('r.media_id = ' . $query->quote($this->getMedia()));

    // Select the username
    $query->select('IF (p.review_id = 1, u.name, u.username) AS username')
      ->leftJoin('#__users u ON u.id = r.user_id');

    $query->leftJoin('#__mediamallfactory_profiles p ON p.user_id = r.user_id');

    // Add filters
    $this->addFilterRatingCondition($query);

    // Order
    $this->addOrder($query);

    return $query;
	}

  protected function addFilterRatingCondition($query)
  {
    $filter = $this->filterValues->get('rating', '');

    if ('' != $filter) {
      $query->where('r.rating = ' . $query->quote($filter));
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

  public function getPagination()
  {
    $pagination = parent::getPagination();

    return $pagination;
  }
}
