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

class MediaMallFactoryFrontendControllerProfile extends JController
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
    $data    = JFactory::getApplication()->input->post->get('profile', array(), 'array');
    $model   = $this->getModel('EditProfile');
    $option  = FactoryApplication::getInstance()->getOption();
    $context = $option.'.edit.profile.data';

    $app->setUserState($context, null);

    if ($model->save($data)) {
      $msg = FactoryText::_('profile_save_success');
    } else {
      $msg = FactoryText::_('profile_save_error');

      $app->setUserState($context, $data);

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'warning');
      }
    }

    $redirect = FactoryRoute::view('editprofile');

    if ('save' == $this->getTask()) {
      $redirect = FactoryRoute::view('profile');
    }

    $this->setRedirect($redirect, $msg);
  }

  public function cancel()
  {
    $this->setRedirect(FactoryRoute::view('list'));
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
