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

class MediaMallFactoryBackendModelInvoices extends FactoryModelAdminList
{
  protected $filters      = array('search');
  protected $default_sort = array('created_at', 'desc');

  protected function getQuery()
  {
    $query = parent::getQuery();

    // Select types.
    $query->select('i.*')
      ->from('#__mediamallfactory_invoices i');

    // Select username.
    $query->select('u.username')
      ->leftJoin('#__users u ON u.id = i.user_id');

    return $query;
  }

  protected function addFilterSearchCondition($query)
  {
    $filter = $this->getState('filter.search');

    if ('' != $filter) {
      $filter = $query->quote('%' . $filter . '%');
      $query->where('(i.title LIKE '.$filter.')');
    }
  }
}
