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

class FactoryModelAdminList extends JModelList
{
  protected $filters      = array();
  protected $default_sort = array();

  public function __construct($config = array())
  {
    $config['filter_fields'] = $this->getFilterFields();

    parent::__construct($config);
  }

  public function getFilters()
  {
    return $this->filters;
  }

  protected function getQuery()
  {
    $query = parent::getListQuery();

    return $query;
  }

  protected function getListQuery()
  {
    $query = $this->getQuery();

    // Add filter conditions.
    foreach ($this->filters as $filter) {
      $method = 'addFilter' . ucfirst($filter) . 'Condition';
      if (method_exists($this, $method)) {
        $this->$method($query);
      }
    }

    // Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');

    if ($orderCol && $orderDirn) {
      $query->order($query->escape($orderCol . ' ' . $orderDirn));
    }

    return $query;
  }

  protected function getFilterFields()
  {
    $app     = JFactory::getApplication();
    $option  = $app->input->getCmd('option', '');
    $name    = $this->getName();
    $context = $option.'.'.$name.'.filters.sort';

    return $app->getUserState($context, array());
  }

  protected function populateState($ordering = null, $direction = null)
	{
    if (is_null($ordering) && isset($this->default_sort[0])) {
      $ordering = $this->default_sort[0];
    }

    if (is_null($direction) && isset($this->default_sort[1])) {
      $direction = $this->default_sort[1];
    }

    $app = JFactory::getApplication();
    $reset_filters = $app->input->get->getInt('reset_filters', 0);

		// Load the filters.
    foreach ($this->filters as $filter) {
      if ($reset_filters) {
        $app->setUserState($this->context.'.filter.'.$filter, '');
      }

		  $value = $this->getUserStateFromRequest($this->context.'.filter.'.$filter, 'filter_'.$filter, null, 'none', false);
		  $this->setState('filter.' . $filter, $value);
    }

    parent::populateState($ordering, $direction);
	}
}
