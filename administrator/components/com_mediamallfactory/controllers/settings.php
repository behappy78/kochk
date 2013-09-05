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

class MediaMallFactoryBackendControllerSettings extends JController
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
    $data    = JFactory::getApplication()->input->post->get('config', array(), 'array');
    $form    = JFactory::getApplication()->input->getCmd('form', 'config');
    $model   = $this->getModel('Settings');
    $option  = FactoryApplication::getInstance()->getOption();
    $context = $option.'.edit.settings.data';

    $app->setUserState($context, null);

    if ($model->save($data)) {
      $msg = FactoryText::_('settings_save_success');
    } else {
      $msg = FactoryText::_('settings_save_error');

      $app->setUserState($context, $data);

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'warning');
      }

      $this->setRedirect(FactoryRoute::view('settings'), $msg);

      return false;
    }

    // Redirect.
    $redirect = FactoryRoute::view('settings&form=' . $form);

    if ('save' == $this->getTask()) {
      $redirect = FactoryRoute::view('configuration');
    }

    $this->setRedirect($redirect, $msg);

    return true;
  }

  public function cancel()
  {
    $this->setRedirect(FactoryRoute::view('dashboard'));
  }
}
