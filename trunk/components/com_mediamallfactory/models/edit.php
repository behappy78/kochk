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

jimport('joomla.application.component.model');

class MediaMallFactoryFrontendModelEdit extends JModel
{
  protected $form_name = 'media';

  public function getForm($loadData = true)
  {
    FactoryApplication::getInstance()->loadLanguage();

		// Get the form.
  	$form = FactoryForm::getInstance($this->form_name, $this->form_name, array(
      'control' => $this->form_name,
      'path_location' => 'site',
    ));

    if ($loadData) {
      $data = $this->loadFormData();
    } else {
      $data = array();
    }

    // Check if author is allowed to set own price or is restricted to upload only free media.
    if (JFactory::getApplication()->isSite()) {
      $user      = JFactory::getUser();
      $own_price = FactoryApplication::getInstance()->getParam('authors.restrictions.own_price', array());
      $only_free = FactoryApplication::getInstance()->getParam('authors.restrictions.only_free', array());

      if (!array_intersect($own_price, $user->groups) || array_intersect($only_free, $user->groups)) {
        $form->removeField('cost_media');
        $form->removeField('cost_archive');
      }
    }

    $form->bind($data);

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

    // Get media.
    $table = $this->getItem($data['id']);

    $this->setState('media_id', $data['id']);

    // Save the media.
    if (!$table->save($data)) {
      $this->setError($table->getError());
      return false;
    }

    $this->setState('media_id', $table->id);
    $this->setState('user_id', $table->user_id);

    return true;
  }

  public function delete($batch)
  {
    JArrayHelper::toInteger($batch);

    // Check if any items are checked.
    if (!$batch) {
      $this->setError(FactoryText::_('list_batch_select_item'));
      return false;
    }

    foreach ($batch as $id) {
      $item = $this->getItem($id);

      if (!$item->delete()) {
        $this->setError($item->getError());
        return false;
      }
    }

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

  public function getItem($id = null)
  {
    static $items = array();

    if (is_null($id)) {
      $id = JFactory::getApplication()->input->get->getInt('media_id', 0);
    }

    if (!isset($items[$id])) {
      $table = FactoryTable::getInstance('Media');
      $table->load($id);

      if (!$this->allowEdit($table)) {
        throw new Exception(FactoryText::_('media_edit_error_not_allowed'), 403);
      }

      $items[$id] = $table;
    }

    return $items[$id];
  }

  public function getPageTitle()
  {
    $title = FactoryText::_('edit_title_page_new');
    $item  = $this->getItem();

    if ($item->id) {
      $title = FactoryText::sprintf('edit_title_page_edit', $item->title, $item->id);
    }

    return $title;
  }

  public function getCancelTitle()
  {
    $item  = $this->getItem();

    if ($item->id) {
      $title = FactoryText::_('media_edit_button_close');
    } else {
      $title = FactoryText::_('media_edit_button_cancel');
    }

    return $title;
  }

  protected function allowEdit($table)
  {
    if (!$table->id) {
      return true;
    }

    return $table->user_id == JFactory::getUser()->id;
  }
}
