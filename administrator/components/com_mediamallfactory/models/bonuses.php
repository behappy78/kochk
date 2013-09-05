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

class MediaMallFactoryBackendModelBonuses extends FactoryModelAdminList
{
  protected $filters      = array('published');
  protected $default_sort = array('credits', 'asc');

  protected function getQuery()
  {
    $query = parent::getQuery();

    // Select bonuses.
    $query->select('b.*')
      ->from('#__mediamallfactory_credits_bonuses b');

    return $query;
  }

  protected function addFilterPublishedCondition($query)
  {
    $filter = $this->getState('filter.published');

    if ('' != $filter) {
      $query->where('b.published = ' . $query->quote($filter));
    }
  }
}
