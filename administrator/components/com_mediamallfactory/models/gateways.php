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

class MediaMallFactoryBackendModelGateways extends FactoryModelAdminList
{
  protected $filters      = array('search', 'published');
  protected $default_sort = array('title', 'asc');

  public function __construct($config = array())
  {
    parent::__construct($config);

    $this->discover();
  }

  protected function getQuery()
  {
    $query = parent::getQuery();
    $table = FactoryTable::getInstance('PaymentGateway');

    // Select media.
    $query->select('g.*')
      ->from($query->quoteName($table->getTableName()) . ' g');

    return $query;
  }

  protected function addFilterSearchCondition($query)
  {
    $filter = $this->getState('filter.search');

    if ('' != $filter) {
      $filter = $query->quote('%' . $filter . '%');
      $query->where('g.title LIKE '.$filter);
    }
  }

  protected function addFilterPublishedCondition($query)
  {
    $filter = $this->getState('filter.published');

    if ('' != $filter) {
      $query->where('g.published = ' . $query->quote($filter));
    }
  }

  protected function discover()
  {
    $dbo = $this->getDbo();
    $table = FactoryTable::getInstance('PaymentGateway');

    $query = $dbo->getQuery(true)
      ->select('g.element')
      ->from($dbo->nameQuote($table->getTableName()) . ' g');
    $results = $dbo->setQuery($query)
      ->loadResultArray();

    jimport('joomla.filesystem.folder');
    $files = JFolder::folders(FactoryApplication::getInstance()->getPath('payment_gateways'));

    $new = 0;

    foreach (array_diff(array_merge($results, $files), array_intersect($results, $files)) as $different) {
      if (!in_array($different, $results)) {
        // Add to database.
        $table = FactoryTable::getInstance('PaymentGateway');

        $table->element = $different;
        $table->title   = $different;

        if ($table->store()) {
          $new++;
        }
      } else {
        // Remove from database.
        $query = $dbo->getQuery(true)
          ->delete()
          ->from($dbo->nameQuote($table->getTableName()))
          ->where('element = ' . $dbo->quote($different));
        $dbo->setQuery($query)
          ->query();
      }
    }

    if ($new) {
      JFactory::getApplication()->enqueueMessage(FactoryText::plural('gateways_added_new_gateways', $new), 'notice');
    }

    return true;
  }
}
