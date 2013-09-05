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

class MediaMallFactoryBackendControllerUser extends JController
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
    $data  = JFactory::getApplication()->input->post->get('profile', array(), 'array');
    $model = $this->getModel('User');
    $id    = JFactory::getApplication()->input->get->getInt('id', 0);

    $data['user_id'] = $id;

    if ($model->save($data)) {
      $msg = FactoryText::_('user_save_success');
    } else {
      $msg = FactoryText::_('user_save_error');

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'error');
      }

      $id = $id ? '&id='.$id : '';
      $this->setRedirect(FactoryRoute::view('user'.$id), $msg);

      return false;
    }

    // Redirect.
    $redirect = FactoryRoute::view('users');

    if ('apply' == $this->getTask()) {
      $redirect = FactoryRoute::view('user&id=' . $model->getState('id'));
    }

    $this->setRedirect($redirect, $msg);

    return true;
  }

  public function cancel()
  {
    $this->setRedirect(FactoryRoute::view('users'));
  }

  public function edit()
  {
    $cid = JFactory::getApplication()->input->post->get('cid', array(), 'array');
    $id  = isset($cid[0]) ? $cid[0] : 0;

    $this->setRedirect(FactoryRoute::view('user&id=' . $id));
  }
}
