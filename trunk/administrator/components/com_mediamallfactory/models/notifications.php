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

class MediaMallFactoryBackendModelNotifications extends FactoryModelAdminList
{
  protected $filters      = array('search', 'type', 'language', 'published');
  protected $default_sort = array('subject', 'asc');

  public function getFilterType()
  {
    $options = array();
    $xml = JFactory::getXML(FactoryApplication::getInstance()->getPath('component_administrator').DS.'notifications.xml');

    foreach ($xml->notification as $notification) {
      $options[(string)$notification->attributes()->type] = FactoryText::_('notification_' . (string)$notification->attributes()->type);
    }

    return $options;
  }

  public function getFilterLanguage()
  {
    $array = JHtml::_('contentlanguage.existing', true);

	  return $array;
  }

  protected function getQuery()
  {
    $query = parent::getQuery();

    // Select notifications.
    $query->select('n.*')
      ->from('#__mediamallfactory_notifications n');

    // Select the language
		$query->select('l.title AS language_title')
      ->leftJoin('#__languages l ON l.lang_code = n.lang_code');

    return $query;
  }

  protected function addFilterSearchCondition($query)
  {
    $filter = $this->getState('filter.search');

    if ('' != $filter) {
      $filter = $query->quote('%' . $filter . '%');
      $query->where('(n.subject LIKE '.$filter.' OR n.body LIKE '.$filter.')');
    }
  }

  protected function addFilterTypeCondition($query)
  {
    $filter = $this->getState('filter.type');

    if ('' != $filter) {
      $query->where('n.type = ' . $query->quote($filter));
    }
  }

  protected function addFilterLanguageCondition($query)
  {
    $filter = $this->getState('filter.language');

    if ('' != $filter) {
      $query->where('n.lang_code = ' . $query->quote($filter));
    }
  }

  protected function addFilterPublishedCondition($query)
  {
    $filter = $this->getState('filter.published');

    if ('' != $filter) {
      $query->where('n.published = ' . $query->quote($filter));
    }
  }
}
