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

class MediaMallFactoryBackendModelUser extends JModel
{
  protected $form_name = 'profile';

  public function getTable($table = 'Profile')
  {
    return FactoryTable::getInstance($table);
  }

  public function getForm($loadData = true)
  {
    FactoryApplication::getInstance()->loadLanguage();
		// Get the form.
  	$form = FactoryForm::getInstance($this->form_name, $this->form_name, array(
      'control' => $this->form_name,
      'path_location' => 'site',
    ));

    // Add user_id field required on the backend.
    $form->load('<form><field name="user_id" type="hidden" /></form>');

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
      if (!$table->load($pk)) {
        throw new Exception(FactoryText::sprintf('user_not_found', $pk), 404);
      }

      $user = JFactory::getUser($pk);
      $table->username = $user->username;

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
    $table = $this->getTable();

    // Save the item.
    if (!$table->save($data)) {
      $this->setError($table->getError());
      return false;
    }

    $this->setState('id', $table->user_id);

    return true;
  }

  protected function loadFormData()
  {
    $data = $this->getItem();

    $data->params = $data->params->toArray();

    return $data;
  }
}
