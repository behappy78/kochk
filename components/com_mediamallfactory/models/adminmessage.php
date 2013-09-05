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

class MediaMallFactoryFrontendModelAdminMessage extends JModel
{
  protected $form_name = 'adminmessage';

  public function getForm()
  {
    // Get the form.
  	$form = FactoryForm::getInstance($this->form_name, $this->form_name, array('control' => $this->form_name));

		return $form;
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

    // Check if we are allowed to save data.
    if (!$this->allowSave($data)) {
      return false;
    }

    $this->prepareData($data);

    // Save the message.
    $table = FactoryTable::getInstance('AdminMessage');

    if (!$table->save($data)) {
      $this->setError($table->getError());
      return false;
    }

    return true;
  }

  protected function allowSave($data)
  {
    return true;
  }

  protected function prepareData($data)
  {
    return $data;
  }
}
