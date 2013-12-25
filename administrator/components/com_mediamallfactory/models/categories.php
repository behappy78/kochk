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

class MediaMallFactoryBackendModelCategories extends FactoryModelAdminList
{
  protected $filters      = array('search', 'published');
  protected $default_sort = array('id', 'asc');

  protected function getQuery()
  {
    $query = parent::getQuery();
    $query->select('c.*, c2.title as c2title, cni.fr as icountryn, cne.fr as ecountryn, gni.countries as incountries, gne.countries as excountries')
      ->from('#__mediamallfactory_category AS c')
      ->join('INNER','#__countries AS cni ON c.icountry=cni.iso3')
      ->join('INNER','#__countries AS cne ON c.ecountry=cne.iso3')
      ->join('INNER','#__mediamallfactory_groups AS gni ON c.icountrygroup=gni.id')
      ->join('INNER','#__mediamallfactory_groups AS gne ON c.ecountrygroup=gne.id')
      ->join('LEFT','#__mediamallfactory_category AS c2 ON c2.id=c.parent_id')
      ->where('c.level=0');
      return $query;
  }
  public function getFilterParent()
  {
    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('t.id AS value, t.title AS text')
      ->from('#__mediamallfactory_category t')
      ->where('t.published = ' . $dbo->quote(1))
      ->where('t.level = ' . $dbo->quote(0))
      ->order('t.title ASC');

    return $dbo->setQuery($query)
      ->loadObjectList();    

    foreach ($xml->notification as $notification) {
      $options[(string)$notification->attributes()->type] = FactoryText::_('notification_' . (string)$notification->attributes()->type);
    }

    return $options;
  }
  protected function addFilterParentCondition($query)
  {
    $filter = $this->getState('filter.parent');

    if ('' != $filter) {
      $query->where('c.parent_id = ' . $query->quote($filter));
    }
  }
  protected function addFilterSearchCondition($query)
  {
    $filter = $this->getState('filter.search');

    if ('' != $filter) {
      $filter = $query->quote('%' . $filter . '%');
      $query->where('(c.title LIKE '.$filter.')');
    }
  }

  protected function addFilterPublishedCondition($query)
  {
    $filter = $this->getState('filter.published');

    if ('' != $filter) {
      $query->where('c.published = ' . $query->quote($filter));
    }
  }
}
