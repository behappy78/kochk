<?php

/**------------------------------------------------------------------------
com_mediamallfactory - Media Mall Factory 3.3.5 
------------------------------------------------------------------------
 * @author TheFactory
 * @copyright Copyright (C) 2011 SKEPSIS Consult SRL. All Rights Reserved.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Websites: http://www.thefactory.ro
 * Technical Support: Forum - http://www.thefactory.ro/joomla-forum/
 * TODO: Change the profile page and creat params page
-------------------------------------------------------------------------*/

defined('_JEXEC') or die;

class MediaMallFactoryFrontendControllerParameters extends JController
{
  public function __construct($config = array())
  {
    parent::__construct($config);
    $this->registerTask('apply', 'save');
  }

  public function save()
  {
    JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

    $app     = JFactory::getApplication();
    $data    = JFactory::getApplication()->input->post->get('parameters', array(), 'array');
    $model   = $this->getModel('EditParameters');
    $option  = FactoryApplication::getInstance()->getOption();
    $context = $option.'.edit.parameters.data';

    $app->setUserState($context, null);
    if ($model->save($data)) {
      $msg = FactoryText::_('params_save_success');
    } else {
      $msg = FactoryText::_('params_save_error');

      $app->setUserState($context, $data);

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'warning');
      }
    }

    $redirect = FactoryRoute::view('editparameters');

    if ('save' == $this->getTask()) {
      $redirect = FactoryRoute::view('parameters');
    }

    $this->setRedirect($redirect, $msg);
  }

  public function cancel()
  {
    $this->setRedirect(FactoryRoute::view('dashboard'));
  }

  public function authorise($task)
  {
    if (!parent::authorise($task)) {
      return false;
    }

    $permissions = array(
      'save' => array('logged'),
      'cancel' => array('logged'),
    );

    if (!isset($permissions[$task])) {
      return true;
    }

    foreach ($permissions[$task] as $permission) {
      FactoryApplication::getInstance()->checkPermission($permission);
    }

    return true;
  }
}
