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

class MediaMallFactoryBackendModelAdminMessage extends JModel
{
  protected $form_name = 'adminmessage';

  public function getForm()
  {
    FactoryApplication::getInstance()->loadLanguage();

    // Get the form.
  	$form = FactoryForm::getInstance($this->form_name, $this->form_name, array(
      'control' => $this->form_name,
      'path_location' => 'site'
    ));

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
      return false;
    }

    $data['user_id']  = JFactory::getUser()->id;
    $data['is_admin'] = 1;

    // Get item.
    $table = $this->getTable();

    // Save the item.
    if (!$table->save($data)) {
      return false;
    }

    return true;
  }

  public function getTable($table = 'AdminMessage')
  {
    return FactoryTable::getInstance($table);
  }
}
