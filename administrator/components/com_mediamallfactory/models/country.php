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

class MediaMallFactoryBackendModelCountry extends JModel
{
  protected $form_name = 'country';

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

  public function getTable($table = 'Country')
  {
    return FactoryTable::getInstance($table);
  }

  public function getForm($loadData = true)
  {
    FactoryForm::addFieldPath('site');

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

    // Get media type.
    $table = $this->getTable();

    // Save the media type.
    if (!$table->save($data)) {
      $this->setError($table->getError());
      return false;
    }

    $this->setState('id', $table->id);

    return true;
  }

  protected function loadFormData()
  {
    // Check the session for previously entered form data.
    $name    = $this->getName();
    $option  = FactoryApplication::getInstance()->getOption();
    $context = $option.'.edit.'.$name.'.data';

    $data = JFactory::getApplication()->getUserState($context, array());
    JFactory::getApplication()->setUserState($context, array());

    if (!$data) {
      $data = $this->getItem();
    }

    return $data;
  }
}
