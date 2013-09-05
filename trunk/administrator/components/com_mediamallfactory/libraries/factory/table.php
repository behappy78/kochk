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

class FactoryTable extends JTable
{
  public static function getInstance($type, $config = array())
	{
    $prefix = FactoryApplication::getInstance()->getComponent() . 'Table';
    JTable::addIncludePath(FactoryApplication::getInstance()->getPath('component_administrator').DS.'tables');

		return parent::getInstance($type, $prefix, $config);
	}

  public function store($updateNulls = false)
  {
    $key = $this->_tbl_key;

    if (property_exists($this, 'created_at') && !$this->$key) {
      $this->created_at = JFactory::getDate()->toMySQL();
    }

    if (property_exists($this, 'updated_at')) {
      $this->updated_at = JFactory::getDate()->toMySQL();
    }

    return parent::store($updateNulls);
  }

  public function load($keys = null, $reset = true)
	{
	  if (!parent::load($keys, $reset)) {
      return false;
    }

    // Convert params.
    if (property_exists($this, 'params')) {
      $this->params = new JRegistry($this->params);
    }

	  return true;
	}

	public function bind($src, $ignore = array())
	{
		if (is_array($src) && isset($src['params']) && is_array($src['params'])) {
			$registry = new JRegistry($src['params']);
			$src['params'] = $registry->toString();
		}

		return parent::bind($src, $ignore);
	}

  public function delete($pk = null)
  {
    $k  = $this->_tbl_key;
		$pk = (is_null($pk)) ? $this->$k : $pk;

    if (!parent::delete($pk)) {
      return false;
    }

    $event = $this->getName().'Delete';

    FactoryApplication::getInstance()->trigger($event, array($pk));

    return true;
  }

  public function publish($state = 1)
  {
    $k = $this->_tbl_key;

    $dbo = $this->getDbo();
    $query = $dbo->getQuery(true)
		  ->update($this->_tbl)
		  ->set('published = ' . (int)$state);
		$query->where($k . ' = ' . $dbo->quote($this->$k));

		$dbo->setQuery($query);

    if (!$dbo->query()) {
      $this->setError($dbo->getErrorMsg());
      return false;
    }

    $event = $this->getName().'Publish';

    FactoryApplication::getInstance()->trigger($event, array($this->$k, $state, $this->user_id));

    return true;
  }

  protected function getName()
  {
    return str_replace(FactoryApplication::getInstance()->getComponent() . 'Table', '', get_class($this));
  }
}
