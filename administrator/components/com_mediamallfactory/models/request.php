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

class MediaMallFactoryBackendModelRequest extends JModel
{
  protected $form_name = 'request';

  public function publish($batch, $value)
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

      if (!$table->publish($value)) {
        $this->setError($table->getError());
        return false;
      }
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

      if (!$table->load($id)) {
        $this->setError($table->getError());
        return false;
      }

      if (!$table->delete()) {
        $this->setError($table->getError());
        return false;
      }
    }

    return true;
  }

  public function getTable($table = 'PaymentRequest')
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

    if ($data && $data->status) {
      $form->setFieldAttribute('status', 'disabled', 'true');
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
      if (!$table->load($pk)) {
        throw new Exception(FactoryText::sprintf('request_save_error_request_not_found', $pk), 404);
      }

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

    // Get item.
    $table = $this->getTable();
    $table->load($data['id']);

    // Check if the item exists.
    if ($data['id'] != $table->id) {
      $this->setError(FactoryText::sprintf('request_save_error_request_not_found', $data['id']));
      return false;
    }

    // Check if request has been Released or Rejected.
    if ($table->status) {
      unset($data['status']);
    }

    // Save the item.
    if (!$table->save($data)) {
      $this->setError($table->getError());
      return false;
    }

    // Trigger Payment Request resolved event.
    if (isset($data['status']) && $data['status']) {
      FactoryApplication::getInstance()->trigger('paymentRequestResolved', array(
        $table->user_id, $table->status, -1 * $table->amount
      ));
    }

    $this->setState('id', $table->id);
    $this->setState('user_id', $table->user_id);

    return true;
  }

  public function getMessages()
  {
    $item = $this->getItem();
    $model = JModel::getInstance('AdminMessages', 'MediaMallFactoryBackendModel');

    return $model->getItems('payment_request', $item->id);
  }

  public function getMessageForm()
  {
    $model = JModel::getInstance('AdminMessage', 'MediaMallFactoryBackendModel');

    return $model->getForm();
  }

  public function getAuthor()
  {
    $item = $this->getItem();

    $table = FactoryTable::getInstance('Profile');
    $table->load($item->user_id);

    return $table;
  }

  public function getAuthorForm()
  {
    // Get the form.
    $name = 'profile';
  	$form = FactoryForm::getInstance($name, $name, array('control' => $name, 'path_location' => 'site'));

    $author = $this->getAuthor();
    $author->params = $author->params->toArray();
    $form->bind($author);

		return $form;
  }

  protected function loadFormData()
  {
    $data = $this->getItem();

    return $data;
  }
}
