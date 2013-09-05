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

class MediaMallFactoryBackendControllerMedia extends JController
{
  public function __construct($config = array())
  {
    parent::__construct($config);

    $this->registerTask('apply', 'save');
    $this->registerTask('save2new', 'save');
  }

  public function save()
  {
    JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

    $app     = JFactory::getApplication();
    $data    = JFactory::getApplication()->input->post->get('media', array(), 'array');
    $model   = $this->getModel('Media');
    $option  = FactoryApplication::getInstance()->getOption();
    $context = $option.'.edit.edit.data';
    $id      = JFactory::getApplication()->input->get->getInt('media_id', 0);

    $app->setUserState($context, null);

    // Prepare files post
    $data = array_merge($data, JFactory::getApplication()->input->files->get('media', array(), 'array'));
    $data['id'] = $id;

    if ($model->save($data)) {
      $msg = FactoryText::_('media_save_success');
    } else {
      $msg = FactoryText::_('media_save_error');

      $app->setUserState($context, $data);

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'warning');
      }

      $media_id = $id ? '&media_id='.$id : '';
      $this->setRedirect(FactoryRoute::view('media'.$media_id), $msg);

      return false;
    }

    // Save admin message.
    $data    = $app->input->post->get('adminmessage', array(), 'array');
    $message = $this->getModel('AdminMessage');

    $data['type']     = 'media';
    $data['item_id']  = $model->getState('media_id');
    $data['owner_id'] = $model->getState('user_id');

    $message->save($data);

    // Redirect.
    $redirect = FactoryRoute::view('list');

    if ('apply' == $this->getTask()) {
      $redirect = FactoryRoute::view('media&media_id=' . $model->getState('media_id'));
    } else if ('save2new' == $this->getTask()) {
      $redirect = FactoryRoute::view('media');
    }

    $this->setRedirect($redirect, $msg);

    return true;
  }

  public function cancel()
  {
    $this->setRedirect(FactoryRoute::view('list'));
  }

  public function add()
  {
    $this->setRedirect(FactoryRoute::view('media'));
  }

  public function edit()
  {
    $cid = JFactory::getApplication()->input->post->get('cid', array(), 'array');
    $id  = isset($cid[0]) ? $cid[0] : 0;

    $this->setRedirect(FactoryRoute::view('media&media_id=' . $id));
  }
}
