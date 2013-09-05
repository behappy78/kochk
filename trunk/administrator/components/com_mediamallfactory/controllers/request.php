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

class MediaMallFactoryBackendControllerRequest extends JController
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
    $data  = JFactory::getApplication()->input->post->get('request', array(), 'array');
    $model = $this->getModel('Request');
    $id    = JFactory::getApplication()->input->get->getInt('id', 0);

    $data['id'] = $id;

    if ($model->save($data)) {
      $msg = FactoryText::_('request_save_success');
    } else {
      $msg = FactoryText::_('request_save_error');

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'error');
      }

      $id = $id ? '&id='.$id : '';
      $this->setRedirect(FactoryRoute::view('request'.$id), $msg);

      return false;
    }

    // Save admin message.
    $data    = $app->input->post->get('adminmessage', array(), 'array');
    $message = $this->getModel('AdminMessage');

    $data['type']     = 'payment_request';
    $data['item_id']  = $model->getState('id');
    $data['owner_id'] = $model->getState('user_id');

    $message->save($data);

    // Redirect.
    $redirect = FactoryRoute::view('requests');

    if ('apply' == $this->getTask()) {
      $redirect = FactoryRoute::view('request&id=' . $model->getState('id'));
    }

    $this->setRedirect($redirect, $msg);

    return true;
  }

  public function cancel()
  {
    $this->setRedirect(FactoryRoute::view('requests'));
  }

  public function edit()
  {
    $cid = JFactory::getApplication()->input->post->get('cid', array(), 'array');
    $id  = isset($cid[0]) ? $cid[0] : 0;

    $this->setRedirect(FactoryRoute::view('request&id=' . $id));
  }
}
