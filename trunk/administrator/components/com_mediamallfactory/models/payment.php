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

class MediaMallFactoryBackendModelPayment extends JModel
{
  protected $form_name = 'payment';

  public function changeStatus($batch, $state = 30)
  {
    JArrayHelper::toInteger($batch);

    if (!$batch) {
      $this->setError(FactoryText::_('list_empty'));
      return false;
    }

    foreach ($batch as $id) {
      $table = $this->getTable();

      if (!$table->load($id)) {
        $this->setError($table->getError());
        return false;
      }

      if (!$table->changeStatus($state)) {
        $this->setError($table->getError());
        return false;
      }

      FactoryApplication::getInstance()->trigger('paymentStatusChange', array(
        $table->id, $table->order_id, $state
      ));
    }

    return true;
  }

  public function delete($batch)
  {
    JArrayHelper::toInteger($batch);

    if (!$batch) {
      $this->setError(FactoryText::_('list_empty'));
      return false;
    }

    foreach ($batch as $id) {
      $table = $this->getTable();

      if (!$table->delete($id)) {
        $this->setError($table->getError());
        return false;
      }
    }

    return true;
  }

  public function getTable($table = 'Payment')
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
      $pk = JFactory::getApplication()->input->getInt('id', 0);
    }

    if (!isset($items[$pk])) {
      $table = $this->getTable();
      $table->load($pk);

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

    $this->setState('id', $data['id']);

    // Get payment.
    $table = $this->getItem($data['id']);

    // Check payment status.
    if (in_array($table->status, array(20, 30))) {
      $this->setError(FactoryText::_('payment_save_error_status'));
      return false;
    }

    // Save the payment.
    if (!$table->save($data)) {
      $this->setError($table->getError());
      return false;
    }

    $this->setState('id', $table->id);

    return true;
  }

  protected function loadFormData()
  {
    $data = $this->getItem();

    return $data;
  }
}
