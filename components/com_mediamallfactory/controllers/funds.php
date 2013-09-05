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

class MediaMallFactoryFrontendControllerFunds extends JController
{
  public function withdraw()
  {
    JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

    $app     = JFactory::getApplication();
    $data    = JFactory::getApplication()->input->post->get('withdraw', array(), 'array');
    $model   = $this->getModel('WithdrawFunds');

    $data['user_id'] = JFactory::getUser()->id;

    if ($model->withdraw($data)) {
      $msg = FactoryText::_('funds_withdraw_success');
    } else {
      $msg = FactoryText::_('funds_withdraw_error');

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'warning');
      }

      $this->setRedirect(FactoryRoute::view('withdrawfunds'), $msg);

      return false;
    }

    $this->setRedirect(FactoryRoute::view('profile'), $msg);

    return true;
  }

  public function convert()
  {
    JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

    $app   = JFactory::getApplication();
    $data  = $app->input->post->get('convert', array(), 'array');
    $model = $this->getModel('ConvertFunds');

    $data['user_id'] = JFactory::getUser()->id;

    if ($model->convert($data)) {
      $msg = FactoryText::_('funds_convert_success');
    } else {
      $msg = FactoryText::_('funds_convert_error');

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'warning');
      }

      $this->setRedirect(FactoryRoute::view('convertfunds'), $msg);

      return false;
    }

    $this->setRedirect(FactoryRoute::view('profile'), $msg);

    return true;
  }

  public function cancel()
  {
    $this->setRedirect(FactoryRoute::view('profile'));
  }

  public function authorise($task)
  {
    if (!parent::authorise($task)) {
      return false;
    }

    $permissions = array(
      'withdraw' => array('logged', 'author'),
      'convert'  => array('logged', 'author'),
      'cancel'   => array('logged', 'author'),
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
