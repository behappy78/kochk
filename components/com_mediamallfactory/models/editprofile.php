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

class MediaMallFactoryFrontendModelEditProfile extends JModel
{
  protected $form_name = 'profile';

  public function getForm($loadData = true)
  {
		// Get the form.
  	$form = FactoryForm::getInstance($this->form_name, $this->form_name, array('control' => $this->form_name));

    if ($loadData) {
      $data = $this->loadFormData();
    } else {
      $data = array();
    }

    $authors = FactoryApplication::getInstance()->getParam('authors.global.author', array());
    if (!array_intersect(JFactory::getUser()->groups, $authors)) {
      $form->removeFieldset('author');
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

    // Save the media.
    $table = JTable::getInstance('Profile', 'MediaMallFactoryTable');

    if (!$table->save($data)) {
      $this->setError($table->getError());
      return false;
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
      $data->params = $data->params->toArray();
	   /*
       * Get the country name from the code
       */
      $country = $data->params['country'];
      $db =& JFactory::getDBO();
      $query = $db->getQuery(true);
      $query->select('fr');
      $query->from('#__countries'); 
      $query->where('iso3 ="'.$country.'"');
      $db->setQuery($query);
      if ($db->getErrorNum()) {
        echo $db->getErrorMsg();
      }
      $results = $db->loadObjectList();
      //echo $country;
      if ($results) {
          $data->params['country'] = $results[0]->fr;
      }      
    }

    return $data;
  }

  public function getItem()
  {
    static $items = array();

    $user_id = JFactory::getUser()->id;

    if (!isset($items[$user_id])) {
      $table = JTable::getInstance('Profile', 'MediaMallFactoryTable');
      $table->load($user_id);

      // Create profile if it doesn't exist.
      if (!$table->user_id) {
        $table = $table->createProfile($user_id);
      }
      $items[$user_id] = $table;
    }

    return $items[$user_id];
  }
}
