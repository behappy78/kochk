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

class MediaMallFactoryBackendModelUsers extends FactoryModelAdminList
{
  protected $filters      = array('search');
  protected $default_sort = array('username', 'asc');

  protected function getQuery()
  {
    $query = parent::getQuery();

    // Select profiles.
    $query->select('p.*')
      ->from('#__mediamallfactory_profiles p')
      ->group('p.user_id');

    // Select username.
    $query->select('u.username')
      ->leftJoin('#__users u ON u.id = p.user_id');

    // Select number of media.
    $query->select('COUNT(m.id) AS media')
      ->leftJoin('#__mediamallfactory_media m ON m.user_id = p.user_id');

    return $query;
  }

  protected function addFilterSearchCondition($query)
  {
    $filter = $this->getState('filter.search');

    if ('' != $filter) {
      $filter = $query->quote('%' . $filter . '%');
      $query->where('u.username LIKE '.$filter.'');
    }
  }
}
