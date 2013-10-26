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

class MediaMallFactoryBackendControllerSubscription extends JController
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
    $data    = JFactory::getApplication()->input->post->get('subscription', array(), 'array');
    $model   = $this->getModel('Subscription');
    $option  = FactoryApplication::getInstance()->getOption();
    $context = $option.'.edit.subscription.data';
    $id      = JFactory::getApplication()->input->get->getInt('id', 0);

    $app->setUserState($context, null);
    $data['id'] = $id;
    if ($model->save($data)) {
      $msg = FactoryText::_('subscription_save_success');
    } else {
      $msg = FactoryText::_('subscription_save_error');

      $app->setUserState($context, $data);

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'error');
      }

      $id = $id ? '&id='.$id : '';
      $this->setRedirect(FactoryRoute::view('subscription'.$id), $msg);

      return false;
    }

    $redirect = FactoryRoute::view('subscriptions');

    if ('apply' == $this->getTask()) {
      $redirect = FactoryRoute::view('subscription&id=' . $model->getState('id'));
    } else if ('save2new' == $this->getTask()) {
      $redirect = FactoryRoute::view('subscription');
    }

    $this->setRedirect($redirect, $msg);

    return true;
  }

  public function cancel()
  {
    $this->setRedirect(FactoryRoute::view('subscriptions'));
  }

  public function add()
  {
    $this->setRedirect(FactoryRoute::view('subscription'));
  }

  public function edit()
  {
    $cid = JFactory::getApplication()->input->post->get('cid', array(), 'array');
    $id  = isset($cid[0]) ? $cid[0] : 0;

    $this->setRedirect(FactoryRoute::view('subscription&id=' . $id));
  }
}
