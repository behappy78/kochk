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

class MediaMallFactoryTableRegistration extends FactoryTable
{
  public $list_limit       = 10;
  public $media_list_limit = 10;

  public function __construct(&$db)
  {
    parent::__construct('#__mediamallfactory_registrations', 'user_id', $db);
  }

  public function check()
  {
    if (!parent::check()) {
      return false;
    }

    if (!isset($this->user_id) || empty($this->user_id)) {
      $this->user_id = JFactory::getUser()->id;
    }

    return true;
  }

  public function store($updateNulls = false)
  {
		$k = $this->_tbl_key;

    $table = JTable::getInstance('Registration', 'MediaMallFactoryTable');
    $table->load($this->$k);

    $isNew = true;
    if ($this->$k == $table->$k) {
      $isNew = false;
    }

		if (!$isNew) {
			$stored = $this->_db->updateObject($this->_tbl, $this, $this->_tbl_key, $updateNulls);
		} else {
			$stored = $this->_db->insertObject($this->_tbl, $this, $this->_tbl_key);
		}

		// If the store failed return false.
		if (!$stored) {
			$e = new JException(JText::sprintf('JLIB_DATABASE_ERROR_STORE_FAILED', get_class($this), $this->_db->getErrorMsg()));
			$this->setError($e);
			return false;
		}

		return true;
  }

  public function createProfile($user_id)
  {
    $table = JTable::getInstance('Registration', 'MediaMallFactoryTable');

    $table->user_id = $user_id;
    $table->credits = FactoryApplication::getInstance()->getParam('general.credits.initial', 5);

    if (!$table->store()) {
      $this->setError($table->getError());
      return false;
    }

    // Log user credits.
    $log = JTable::getInstance('CreditsLog', 'MediaMallFactoryTable');
    $log->record($table->credits, $table->user_id, 'Initial');

    $table->load($user_id);

    return $table;
  }

  public function updateCredits($credits)
  {
    $this->credits += $credits;

    if (!$this->store()) {
      return false;
    }

    return true;
  }

  public function updateBalance($amount)
  {
    $this->balance           += $amount;
    $this->balance_available += $amount;
    $this->revenue           += $amount;

    if (!$this->store()) {
      return false;
    }

    return true;
  }

  public function updateBalanceAvailable($amount)
  {
    $this->balance_available += $amount;

    if (!$this->store()) {
      return false;
    }

    return true;
  }

  public function getBalanceAvailable()
  {
    return $this->balance_available;
  }

  public function syncBalance($status)
  {
    if (1 == $status) {
      $this->balance = $this->balance_available;
    } else {
      $this->balance_available = $this->balance;
    }

    return $this->store();
  }
}
