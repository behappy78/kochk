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

class MediaMallFactoryBackendModelList extends FactoryModelAdminList
{
  protected $filters      = array('search', 'messages', 'category', 'type', 'published');
  protected $default_sort = array('title', 'asc');

  public function getFilterCategory()
  {
    return JHtml::_('category.options', FactoryApplication::getInstance()->getOption());
  }

  public function getFilterType()
  {
    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
      ->select('t.id AS value, t.title AS text')
      ->from('#__mediamallfactory_types t')
      ->where('t.published = ' . $dbo->quote(1))
      ->order('t.title ASC');

    return $dbo->setQuery($query)
      ->loadObjectList();
  }

  public function getFilterMessages()
  {
    return array(
      0 => FactoryText::_('list_filter_messages_no_new_messages_label'),
      1 => FactoryText::_('list_filter_messages_new_messages_label'),
    );
  }

  protected function getQuery()
  {
    $query = parent::getQuery();

    // Select media.
    $query->select('m.*')
      ->from('#__mediamallfactory_media m')
      ->group('m.id');

    // Select username.
    $query->select('u.username')
      ->leftJoin('#__users u ON u.id = m.user_id');

    // Select category.
    $query->select('c.title AS category_title')
      ->leftJoin('#__mediamallfactory_category c ON c.id = m.category_id');

    // Select type.
    $query->select('t.title AS type_title')
      ->leftJoin('#__mediamallfactory_types t ON t.id = m.type_id');

    // Select messages.
    $query->select('COUNT(am.id) AS messages')
      ->leftJoin('#__mediamallfactory_admin_messages am ON am.item_id = m.id AND am.is_admin = ' . $query->quote(0) . ' AND am.pending = ' . $query->quote(1));

    return $query;
  }

  protected function addFilterSearchCondition($query)
  {
    $filter = $this->getState('filter.search');

    if ('' != $filter) {
      if (0 === strpos($filter, 'user:')) {
        $filter = $query->quote(trim(str_replace('user:', '', $filter)));
        $query->where('u.username = ' . $filter);
      } else {
        $filter = $query->quote('%' . $filter . '%');
        $query->where('(m.title LIKE '.$filter.' OR u.username LIKE '.$filter.')');
      }
    }
  }

  protected function addFilterPublishedCondition($query)
  {
    $filter = $this->getState('filter.published');

    if ('' != $filter) {
      $query->where('m.published = ' . $query->quote($filter));
    }
  }

  protected function addFilterCategoryCondition($query)
  {
    $filter = $this->getState('filter.category');

    if ('' != $filter) {
      $query->where('m.category_id = ' . $query->quote($filter));
    }
  }

  protected function addFilterTypeCondition($query)
  {
    $filter = $this->getState('filter.type');

    if ('' != $filter) {
      $query->where('m.type_id = ' . $query->quote($filter));
    }
  }

  protected function addFilterMessagesCondition($query)
  {
    $filter = $this->getState('filter.messages');

    if ('' != $filter) {
      if (1 == $filter) {
        $query->having('messages > ' . $query->quote(0));
      } else {
        $query->having('messages = ' . $query->quote(0));
      }
    }
  }
}
