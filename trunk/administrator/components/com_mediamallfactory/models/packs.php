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

class MediaMallFactoryBackendModelPacks extends FactoryModelAdminList
{
  protected $filters      = array('search', 'published');
  protected $default_sort = array('id', 'asc');

  protected function getQuery()
  {
    $query = parent::getQuery();
    // Select pack.
    $query->select('t.*, c.currency AS currc, c1.fr AS countryf, g.title AS cgroup')
      ->from('#__mediamallfactory_packs AS t')
      ->join('INNER', '#__countries AS c ON t.currency=c.id')
      ->join('INNER', '#__countries AS c1 ON t.country=c1.iso3')
      ->join('INNER', '#__mediamallfactory_groups AS g ON t.country_group=g.id');
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