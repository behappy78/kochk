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

class MediaMallFactoryBackendControllerUserBalance extends JController
{
  public function __construct($config = array())
  {
    parent::__construct($config);

    $this->registerTask('apply', 'save');
  }

  public function save()
  {
    JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

    $app   = JFactory::getApplication();
    $data  = JFactory::getApplication()->input->post->get('userbalance', array(), 'array');
    $model = $this->getModel('UserBalance');
    $id    = JFactory::getApplication()->input->get->getInt('user_id', 0);

    if ($model->save($data)) {
      $msg = FactoryText::_('userbalance_save_success');
    } else {
      $msg = FactoryText::_('userbalance_save_error');

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'error');
      }

      $id = $id ? '&user_id='.$id : '';
      $this->setRedirect(FactoryRoute::view('userbalance'.$id), $msg);

      return false;
    }

    // Redirect.
    $redirect = FactoryRoute::view('users');

    if ('apply' == $this->getTask()) {
      $redirect = FactoryRoute::view('userbalance&user_id='.$id);
    }

    $this->setRedirect($redirect, $msg);

    return true;
  }

  public function cancel()
  {
    $this->setRedirect(FactoryRoute::view('users'));
  }
}
