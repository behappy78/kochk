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

class MediaMallFactoryBackendModelUserBalance extends JModel
{
  protected $form_name = 'userbalance';

  public function getTable($table = 'Profile')
  {
    return FactoryTable::getInstance($table);
  }

  public function getForm($loadData = true)
  {
		// Get the form.
  	$form = FactoryForm::getInstance($this->form_name, $this->form_name, array(
      'control' => $this->form_name,
    ));

    if ($loadData) {
      $data = $this->loadFormData();
    } else {
      $data = array();
    }

    $form->bind($data);

		return $form;
  }

  public function getItem($pk = null)
  {
    static $items = array();

    if (is_null($pk)) {
      $pk = JFactory::getApplication()->input->getInt('user_id', 0);
    }

    if (!isset($items[$pk])) {
      $table = $this->getTable();
      if (!$table->load($pk)) {
        throw new Exception(FactoryText::sprintf('user_not_found', $pk), 404);
      }

      $user = JFactory::getUser($pk);
      $table->_username = $user->username;

      $items[$pk] = $table;
    }

    return $items[$pk];
  }

  public function save($data)
  {
    // Initialise variables.
    $form   = $this->getForm(false);
    $data   = $form->filter($data);
    $return = $form->validate($data);

    // Check if form is valid.
    if (!$return) {
      foreach ($form->getErrors() as $message) {
				$this->setError(JText::_($message));
			}

      return false;
    }

    $this->setState('id', $data['user_id']);

    // Get item.
    $table = $this->getItem($data['user_id']);
    $amount = $data['type'] * $data['value'];
    if (!$table->updateBalance($amount)) {
      $this->setError($table->getError());
      return false;
    }

    // Trigger credits update event.
    FactoryApplication::getInstance()->trigger('balanceUpdate', array(
      $amount, $table->user_id, 'Admin'
    ));

    return true;
  }

  protected function loadFormData()
  {
    $data = $this->getItem();

    return $data;
  }
}
