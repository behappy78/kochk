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

class MediaMallFactoryFrontendModelRegistration extends JModel
{
  protected $form_name = 'registration';
  public function __construct($config){
      
    $user = JFactory::getUser();
    if (!$user->guest)
    {
        $app=JFactory::getApplication();
        $url=JRoute::_(JURI::base()."index.php?option=com_mediamallfactory&view=list");
        $app->redirect($url, "U R Already a member");
    }
  
    $data    = JRequest::get( 'post' );
    if ($data){
        //if (!JSession::checkToken()) jexit(JText::_('JINVALID_TOKEN'));
        //print_r($data);
        $step_todo = (int)$data['step'];
        
        $session =& JFactory::getSession();
        
        $step = $session->get('step');
        
        $maxSteps = (int)$session->get('maxSteps_');
        //echo $maxSteps;
        //die();
        $formulaire = $data;
        
        /*
         * @author Feki Hichem
         * Description Save the data to temp until it finishes entering all Datas 
         */
        if ($step < 1)
            $step = 1;
            //echo "todo: ".$step_todo;
        switch ($step_todo) {
            case 1: if ($step < $maxSteps)
                    $step ++;
            break;
            case 2:
                if ($step > 1) 
                    $step --;
            echo $step; 
            break;
            case 0:
                    $session->clear('step');
                    return false;
            break;
        }
        $session->set("step", $step);  
       }
    //echo '<div id="kochkmain">';   
    parent::__construct($config);  
       
    }
  public function getForm($loadData = true)
  {

		// Get the form.
  	$form = FactoryForm::getInstance($this->form_name, $this->form_name, array('control' => $this->form_name));

    if ($loadData) {
      $data = $this->loadFormData();
    } else {
      $data = array();
    }

    $session =& JFactory::getSession();
	if($session->has('step'))
    {
        $step = $session->get('step');
    }
    else {
        $step = 1;
    }
    $session->set("step", $step);
    $config = $form->getFieldsset('config');
    
    for ($i=0; $i<count($config[0]->field); $i++)
    {
        //echo $config[0]->field[$i]['name']."   ". $config[0]->field[$i]['default'];
        $name = $config[0]->field[$i]['name'].'_';
        $value = (int)$config[0]->field[$i]['default'];
        $session->set($name, $value);
    }
    //die();
    
    for ($i=1;$i<=4;$i++){
        if ($i != $step)
            $form->removeFieldset($i);
    }
    $form->removeFieldset('config');    
    $form->bind($data);
    //print_r($form);
    //die();
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
    $table = JTable::getInstance('Registration', 'MediaMallFactoryTable');

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
      $table = JTable::getInstance('Registration', 'MediaMallFactoryTable');
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
