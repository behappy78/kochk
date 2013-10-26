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

class MediaMallFactoryBackendModelSubscriptions extends FactoryModelAdminList
{
  protected $filters      = array('search', 'published');
  protected $default_sort = array('title', 'asc');

  protected function getQuery()
  {
    $query = parent::getQuery();
    $query->select('t.*, c1.fr AS country, CONCAT(g.title, ": ", g.countries) AS countries')
      ->from('#__mediamallfactory_subscription AS t')
      ->join('INNER', '#__countries AS c1 ON t.country_id=c1.iso3')
      ->join('INNER', '#__mediamallfactory_groups AS g ON t.group_id=g.id');
      return $query;
  }

  protected function addFilterSearchCondition($query)
  {
    $filter = $this->getState('filter.search');

    if ('' != $filter) {
      $filter = $query->quote('%' . $filter . '%');
      $query->where('(t.title LIKE '.$filter.')');
    }
  }

  protected function addFilterPublishedCondition($query)
  {
    $filter = $this->getState('filter.published');

    if ('' != $filter) {
      $query->where('t.published = ' . $query->quote($filter));
    }
  }
}
