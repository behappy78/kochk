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

class MediaMallFactoryBackendControllerGroup extends JController
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
    $data    = JFactory::getApplication()->input->post->get('group', array(), 'array');
    $model   = $this->getModel('Group');
    $option  = FactoryApplication::getInstance()->getOption();
    $context = $option.'.edit.group.data';
    $id      = JFactory::getApplication()->input->get->getInt('id', 0);

    $app->setUserState($context, null);
    $data['id'] = $id;
    $data['countries'] = implode(",", $data['countries']); 
    if ($model->save($data)) {
      $msg = FactoryText::_('group_save_success');
    } else {
      $msg = FactoryText::_('group_save_error');

      $app->setUserState($context, $data);

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'error');
      }

      $id = $id ? '&id='.$id : '';
      $this->setRedirect(FactoryRoute::view('group'.$id), $msg);

      return false;
    }

    $redirect = FactoryRoute::view('groups');

    if ('apply' == $this->getTask()) {
      $redirect = FactoryRoute::view('group&id=' . $model->getState('id'));
    } else if ('save2new' == $this->getTask()) {
      $redirect = FactoryRoute::view('group');
    }

    $this->setRedirect($redirect, $msg);

    return true;
  }

  public function cancel()
  {
    $this->setRedirect(FactoryRoute::view('groups'));
  }

  public function add()
  {
    $this->setRedirect(FactoryRoute::view('group'));
  }

  public function edit()
  {
    $cid = JFactory::getApplication()->input->post->get('cid', array(), 'array');
    $id  = isset($cid[0]) ? $cid[0] : 0;

    $this->setRedirect(FactoryRoute::view('group&id=' . $id));
  }
}
