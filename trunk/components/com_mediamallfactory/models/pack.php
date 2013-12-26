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

class MediaMallFactoryFrontendModelPack extends JModel
{
  protected $form_name = 'pack';
  public function __construct($config){
    $session = JFactory::getSession();
    $db =& JFactory::getDBO();
    $user = JFactory::getUser();
    if (!$user->guest)
    {
        $app=JFactory::getApplication();
        $url=JRoute::_(JURI::base()."index.php?option=com_mediamallfactory&view=list");
        $id = $user->id;
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__mediamallfactory_profiles'); 
        $query->where('user_id ='.(int)$id);
        //$query->where('profiled = 1');  
        $db->setQuery($query);
        $results = $db->loadObjectList();
        if (!$results) {
            $session->set('step', 4);
        }                  
        else 
        {
            if ($results[0]->profiled == 1)
            {
                $session->set('step', 3);
            }
            else 
            {
                // TODO: have to save to original link and redirect to it here
                $session->set('step', 4);
            }
            //$app->redirect($url, "U R Already a member");
        }
        $session->set('stepD', $session->get('step'));
    }
        $jinput = JFactory::getApplication()->input;

        /*
         * check the session state if it's new, restart form
         */
        
        $format = $jinput->get->get('format', 'html');
        $view = $jinput->get->get('view', '');
        $ccode = $jinput->get->get('cf', '');
        
        if ($format == 'html' && $user->guest)
        {
            if ($session->has('step'))
            {
                $session->clear('step');
                //$session->set('step', 3);
                //$session->set('stepD', $session->get('step'));
                //$session->clear('stepD');
                //$session->clear('data_1');
                //$session->clear('data_2');
                //$session->clear('data_3');
                //$session->clear('data_4');
                //$session->clear('data_5');
            }
            if ($ccode != '') 
            {
                $query = $db->getQuery(true);
                $query->select('params');
                $query->from('#__users'); 
                $query->where('params LIKE '.$db->quote('%'.$ccode.'%'));
                $db->setQuery($query);
                
                $results = $db->loadObjectList();
                //echo $query;
                if ($results) {
                    
                    $res = json_decode($results[0]->params);
                    $confcode = $res->code;
                    $query = $db->getQuery(true);
                    $query->update('#__users');
                    $query->set(array($db->quoteName('params') . '='.$db->quote('{}'))); 
                    $query->where('params LIKE '.$db->quote('%'.$confcode.'%'));
                    
                    $db->setQuery($query);
                    $result = $db->query();
                    if (!$result)
                        throw new Exception("Could not update user. Error: ");
                    else 
                        $verif = true;

                    $session->set('step',4);
                    $session->set('stepD', $session->get('step'));
                }
                else 
                {
                    $confcode = '';
                    $this->printMessage('Confirmation code: is wrong');
                } 
            }
      }
        else 
        {
          if($view != 'ajax')
          {
              $data    = JRequest::get( 'post' );
              $step = (int)$session->get('step');
              $data    = JRequest::get( 'post' );
                if ($data){
                    //if (!JSession::checkToken()) jexit(JText::_('JINVALID_TOKEN'));
                    //print_r($data);
                    $step_todo = (int)$data['step'];
                    
                    $session = JFactory::getSession();
                    
                    $step = $session->get('step');
                    $stepD = $session->get('stepD');
                    
                    $maxSteps = (int)$session->get('maxSteps_');
                    //echo $maxSteps;
                    //die();
                    $formulaire = $data;
                    
                    /*
                     * @author Feki Hichem
                     * Description Save the data to temp until it finishes entering all Datas 
                     */
                    //if ($step < 1)
                      //  $step = 1;
                        $session->set('data_'.$step, $data);
                        //echo "todo: ".$step_todo;
                    switch ($step_todo) {
                        case 1: if ($step < $maxSteps)
                            {
                            /*
                             * verification des données ici
                             */
                                $verif = true;
                                switch ($step) {
                                    case 1:
                                        $verif = !$this->verifLogin($data['loginId']);
                                        $verif = !$this->verifEmail($data['inputEmail'], $data['confirmEmail']) && $verif;
                                        $verif = $this->verifPassword($data['Password'], $data['confPassword'], $data['loginId'], $data['inputEmail']) && $verif;
                                        if ($verif)
                                        {
                                            $code = $this->sendEmail($data);
                                            $cruser = $this->creatUser($data['loginId'], $data['loginId'], $data['Password'], $data['inputEmail'], $code);
                                            if ($cruser[0])
                                            {
                                                $session->set('stepD', $step + 1);
                                            }
                                            else 
                                                throw new Exception("Could not creat user. Error: " . $cruser[1]);
                                        }
                                    break;
                                    case 2: 
                                    	$verif = true;
                                        if ($session->has("confcode"))
                                            $confcode = $session->get("confcode");
                                        else 
                                        {
                                            $query = $db->getQuery(true);
                                            $query->select('params, id');
                                            $query->from('#__users'); 
                                            $query->where('params LIKE '.$db->quote($data['verifVcode']));
                                            $db->setQuery($query);
                                            
                                            $results = $db->loadObjectList();
                                            //echo $query;
                                            if ($results) {
                                                print_r($results);
                                                die();
                                                $confcode = $results[0];
                                            }
                                            else 
                                                $verif = false; 
                                        }
                                        
                                        
                                        $query = $db->getQuery(true);
                                        $query->update('#__users');
                                        $query->set(array($db->quoteName('params') . '='.$db->quote('{}'))); 
                                        $query->where('params LIKE '.$db->quote('%'.$confcode.'%'));
                                        
                                        $db->setQuery($query);
                                        $result = $db->query();
                                        if (!$result)
                                            throw new Exception("Could not update user. Error: ");
                                        else 
                                            $verif = true;
                                        
                                        if ($verif)
                                        {
                                        	$username = JRequest::getVar( 'username', 'hichem' );
                                        	$password = JRequest::getVar( 'password', 'hichem' );
                                        	
                                        	jimport('joomla.user.authentication');
                                        	
                                        	$app = JFactory::getApplication();
                                        	
                                        	$credentials = array( "username" => $username, "password" => $password);
                                        	$options = array("silent" => true);
                                        	
                                        	$authorized = $app->logout(null, $options);
                                        	$authorized = $app->login($credentials, $options);
                                        	$user = JFactory::getUser();                                        	
                                        }
                                            
                                    break;
                                    case 4:
                                        print_r($data);
                                        $user = JFactory::getUser();
                                        $infos =new stdClass();
                                        if (!$user->guest)
                                        {
                                            $params = array();
                                            $params['first_name'] = $db->quote($data['first_name']);
                                            $params['last_name'] = $db->quote($data['last_name']);
                                            $params['address'] = $db->quote($data['address']);
                                            $params['city'] = $db->quote($data['city']);
                                            $params['zip'] = $db->quote($data['zip']);
                                            $params['country'] = $db->quote($data['country']);
                                            $params['timezone'] = (int)$data['timezone'];
                                            $params['phone'] = $db->quote($data['phone']);
                                            $params['fax'] = $db->quote($data['fax']);
                                            $params['notifications'] = array();
                                            $params['notifications']['user_invoice_issued'] = 0;
                                            $infos->user_id = $user->id;
                                            $infos->credits = 0;
                                            $infos->balance = 0;
                                            $infos->balance_available = 0;
                                            $infos->revenue = 0;
                                            $infos->review_id = 0;
                                            $infos->allow_contact = 0;
                                            $infos->list_limit = 10;
                                            $infos->media_list_limit = 10;
                                            $infos->profiled = 0;
                                            $infos->params = json_encode($params);
                                            //print_r($params);
                                            $db = JFactory::getDBO();
                                            $db->insertObject( '#__mediamallfactory_profiles', $infos, user_id );   
                                            $query = $db->getQuery(true);
                                            $query->update('#__users');
                                            $query->set(array($db->quoteName('name') . '='.$db->quote($data['first_name'].' '.$data['last_name'])));
                                            $query->where('id = '.$user->id);
                                            
                                            $db->setQuery($query);
                                            $result = $db->query();
                                            if (!$result)
                                            	throw new Exception("Could not update user. Error: ");
                                            else
                                            	$verif = true;
                                            
                                        }
                                         else 
                                         {
                                             // not logged in
                                             // TODO: save data later
                                         }   
                                    break;
                                    default:
                                        ;
                                    break;
                                }
                                //echo 'step: '.$step;
                                if ($verif)
                                    $step ++;
                                $session->set("step", $step);
                            }
                            else {
                                echo "akbar min max";
                                die();
                            }
                        break;
                        case 2:
                            if ($step > $stepD) 
                                $step --;
                                $session->set("step", $step);
                        break;
                        case 3:
                            print_r($data['pack']);

                             /* @TODO: saving data*/
                        break;            
                        case 0:
                                $session->clear('step');
                                //$session->clear('stepD');
                                //$session->clear('data_1');
                                //$session->clear('data_2');
                                //$session->clear('data_3');
                                //$session->clear('data_4');
                                //$session->clear('data_5');                    
                                return false;
                        break;
                    }
                      
                   }              
              
              //die();
          }             
        }  
    //echo '<div id="kochkmain">';   
    parent::__construct($config);  
       
    }
    public function printMessage($message)
    {
        echo'
        <section class="s-holder"><div class="alert alert-error"><button data-dismiss="alert" class="close" type="button">×</button><strong>Error</strong>
        	<ul>
        		<li>'.$message.'</li>
        	</ul></div></section>';
    }
    private function creatUser($name, $username, $password, $email, $code)
    {
        jimport('joomla.user.helper');
        $salt   = JUserHelper::genRandomPassword(32);
        $crypted  = JUserHelper::getCryptedPassword($password, $salt);
        $cpassword = $crypted.':'.$salt;
        
        $data = array(
          "name"=>$name,
          "username"=>$username,
          "password"=>$password,
          "password2"=>$password,
          "email"=>$email,
          "block"=>0,
          "params"=>array("code"=>$code),
          "groups"=>array("1","2")
        );
        
        $user = new JUser;
        //Write to database
        if(!$user->bind($data)) {
            return array (false, $user->getError());
          //throw new Exception("Could not bind data. Error: " . $user->getError());
        }
        if (!$user->save()) {
            return array (false, $user->getError());
            //throw new Exception("Could not save user. Error: " . $user->getError());
        }        
        return array (true);
    }
    private function sendEmail($data)
    {
        //die();
        $session = JFactory::getSession();
        $confcode = uniqid();
        $session->set('confcode', $confcode);
        $this->printMessage('Confirmation code: '.$confcode);
        $mailer = JFactory::getMailer();
        $sender = array( 
            'feki.hichem@gmail.com',
            'Kochk' );
        $mailer->setSender($sender);
        $recipient = $data['inputEmail'];
        $mailer->addRecipient($recipient);
        $body   = '<h2>Confirmation email</h2>'
            . '<div>Confirmation code: '.$confcode
            . '<img src="cid:logo_id" alt="logo"/></div>';
        $mailer->isHTML(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);
        // Optionally add embedded image
        $mailer->AddEmbeddedImage( JPATH_COMPONENT.'/assets/logo128.jpg', 'logo_id', 'logo.jpg', 'base64', 'image/jpeg' );
        /*$send = $mailer->Send();
        if ( $send !== true ) {
            echo 'Error sending email: ' . $send->get('message');
        } else {
            echo 'Mail sent'.$recipient.' '.$body;
        }*/
        return $confcode;
    }
    private function verifLogin($fields)
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(true);
    $query->select('id');
    $query->from('#__users'); 
    $query->where('username ='.$db->quote($fields));
    $db->setQuery($query);
    
    $results = $db->loadObjectList();
    //echo $query;
    if ($results) {
        echo 'Username exists';
        return true;
    }
    else 
        return false;
      
  }
  private function verifPassword($fields, $conf, $name, $email)
  {
     $vl = preg_match('/^[- a-z0-9,<>()&\%$#!~`]{5,40}$/i', $fields) ? true : false;
      if (!$vl) {
          $this->printMessage('Your password contains invalid caraceters.');
          return false;
      }
      if (is_numeric($fields)) {
          $this->printMessage('Your password cannot be all numbers.');
          return false;
        
      } elseif (strlen(count_chars($fields, 3)) < 4) {
          $this->printMessage('Your password needs to have a variety of different characters.');
          return false;
        
      }
    
      // levenshtein distance test (test similarity to common passwords)
      $badPasswords = array($name, $email, 'password', 'password1', 'password123', '1234abcd', 'abcd1234', '12345678', '1234567890');
    
      foreach($badPasswords as $bad) {
        if (levenshtein($fields, $bad) < 6) {
              $this->printMessage('Your password is too similar to your name or email address or other common passwords.');
              return false;
        }
      }
    
     if($fields === $conf)
         return true; 
     return true;
      
  }
  private function verifEmail($fields, $conf)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('id');
        $query->from('#__users'); 
        $query->where('email ='.$db->quote($fields));
        $db->setQuery($query);
        
        $results = $db->loadObjectList();
        //echo $query;
        if ($results) {
            return true;
        }
        return $fields != $conf;
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

    $session = JFactory::getSession();
	if($session->has('step'))
    {
        $step = $session->get('step');
    }
    else {
        $step = 1;
        $session->set("stepD", $step);
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
      /*$country = $data->params['country'];
      $db = JFactory::getDBO();
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
      }*/      
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
