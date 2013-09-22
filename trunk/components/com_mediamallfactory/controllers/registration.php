<?php

/**------------------------------------------------------------------------
com_mediamallfactory - Media Mall Factory 3.3.5 
------------------------------------------------------------------------
 * @author Feki Hichem
 * @copyright Copyright (C) 2011 SKEPSIS Consult SRL. All Rights Reserved.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Websites: http://www.thefactory.ro
 * Technical Support: Forum - http://www.thefactory.ro/joomla-forum/
-------------------------------------------------------------------------*/

defined('_JEXEC') or die;

class MediaMallFactoryFrontendControllerRegistration extends JController
{
  public function __construct($config = array())
  {
     
    parent::__construct($config);
    
    $this->registerTask('apply', 'save');
  }
  public function next()
  {
    JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

    $app     = JFactory::getApplication();
    $data    = JFactory::getApplication()->input->post->get('registration', array(), 'array');
    $model   = $this->getModel('Registration');
    $option  = FactoryApplication::getInstance()->getOption();
    $context = $option.'.registration.data';

    //$app->setUserState($context, null);
    //if ('save' == $this->getTask()) {
    //    $data["profiled"] = 1;}
    $session =& JFactory::getSession();
	if($session->has('step'))
    {
        $step = $session->get('step');
    }
    else {
        $step = 0;
    }
    if ($step < (int)$session->get('maxSteps_'))
        $step ++;
    
    $msg = "to step:".$step;
    $session->set("step", $step);
    //$redirect = FactoryRoute::view('registration');
    $redirect = FactoryRoute::_('view=registration');    
    $this->setRedirect($redirect, $msg);
  }
  public function previous()
  {
    JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

    $app     = JFactory::getApplication();
    $data    = JFactory::getApplication()->input->post->get('registration', array(), 'array');
    $model   = $this->getModel('Registration');
    $option  = FactoryApplication::getInstance()->getOption();
    $context = $option.'.registration.data';

    //$app->setUserState($context, null);
    //if ('save' == $this->getTask()) {
    //    $data["profiled"] = 1;}
    //$step = (int)JFactory::getApplication()->input->getCmd('step', 0);
    $session =& JFactory::getSession();
	if($session->has('step'))
    {
        $step = $session->get('step');
    }
    else {
        $step = 2;
    }
    if ($step > 1)
        $step --;
    $msg = "to step:".($step);
    $session->set("step", $step);
   
    $msg = "to step:".$step;        
    $redirect = FactoryRoute::view('registration');
    //    $redirect = FactoryRoute::_('view=registration');
    
        $this->setRedirect($redirect, $msg);
  }  
  public function save()
  {
    JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

    $app     = JFactory::getApplication();
    $data    = JFactory::getApplication()->input->post->get('registration', array(), 'array');
    $model   = $this->getModel('Registration');
    $option  = FactoryApplication::getInstance()->getOption();
    $context = $option.'.registration.data';

    //$app->setUserState($context, null);
    //if ('save' == $this->getTask()) {
    //    $data["profiled"] = 1;}
    if ($model->save($data)) {
      $msg = FactoryText::_('registration_save_success');
    } else {
      $msg = FactoryText::_('registration_save_error');

      $app->setUserState($context, $data);

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'warning');
      }
    }

    $redirect = FactoryRoute::view('registration');

    if ('save' == $this->getTask()) {
      $redirect = FactoryRoute::view('editprofile');
    }

    $this->setRedirect($redirect, $msg);
  }

  public function cancel()
  {
    $session =& JFactory::getSession();
    $session->clear('step');
    $this->setRedirect(FactoryRoute::view('list'));
  }

  public function authorise($task)
  {
    if (!parent::authorise($task)) {
      return false;
    }

   //$permissions = array(
   //   'save' => array('logged'),
    //  'cancel' => array('logged'),
    //);

    if (!isset($permissions[$task])) {
      return true;
    }

    foreach ($permissions[$task] as $permission) {
      FactoryApplication::getInstance()->checkPermission($permission);
    }

    return true;
  }
}
