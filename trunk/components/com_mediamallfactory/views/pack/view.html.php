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

class MediaMallFactoryFrontendViewPack extends FactoryView
{
  protected
    $get = array('item', 'form', 'state'),
    $css = array('edit'),
    $js = array('edit'),
    $behaviors = array('formvalidation', 'tooltip'),
    $jtexts = array('JGLOBAL_VALIDATION_FORM_FAILED')
   	
  	;
  	public function __construct($config)
  	{
  	    /*
  	     * to login the user automatically
  	     *
        $username = JRequest::getVar( 'username', 'hichem' );   
        $password = JRequest::getVar( 'password', 'hichem' );   
    
        jimport('joomla.user.authentication');

        $app = JFactory::getApplication();

        $credentials = array( "username" => $username, "password" => $password);
        $options = array("silent" => true);

        $authorized = $app->logout(null, $options);
        $authorized = $app->login($credentials, $options);
        $user = JFactory::getUser();
        */
  	    //$newid = $this->addJoomlaUser1('Souheila Chtourou', 'souheila', 'souheila', 'souhe1ila@me.net');
  	    
        parent::__construct($config);     
  	    
  	}
    function addJoomlaUser($name, $username, $password, $email) {
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
              "groups"=>array("1","2")
          );
    
          $user = new JUser;
          //Write to database
          if(!$user->bind($data)) {
              throw new Exception("Could not bind data. Error: " . $user->getError());
          }
          if (!$user->save()) {
              throw new Exception("Could not save user. Error: " . $user->getError());
          }
        jimport('joomla.user.authentication');

        $app = JFactory::getApplication();

        $credentials = array( "username" => $username, "password" => $password);
        $options = array("silent" => true);

        $authorized = $app->logout(null, $options);
        $authorized = $app->login($credentials, $options);
        $user = JFactory::getUser();    
      return $user->id;
    } 
    function addJoomlaUser1($name, $username, $password, $email) {
            $data = array(
                "name"=>$name, 
                "username"=>$username, 
                "password"=>$password,
                "password2"=>$password,
                "email"=>$email,
            	"groups"=>array("1","2")
            );
    
            $user = clone(JFactory::getUser());
            //Write to database
            if(!$user->bind($data)) {
                throw new Exception("Could not bind data. Error: " . $user->getError());
            }
            if (!$user->save()) {
                throw new Exception("Could not save user. Error: " . $user->getError());
            }
    
            return $user->id;
    }
}
