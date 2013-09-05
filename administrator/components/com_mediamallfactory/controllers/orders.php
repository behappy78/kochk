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

class MediaMallFactoryBackendControllerOrders extends JController
{
  public function __construct($config = array())
  {
    parent::__construct($config);

    $this->registerTask('markpaid', 'changepaid');
    $this->registerTask('markunpaid', 'changepaid');

    $this->registerTask('markcomplete', 'changestatus');
    $this->registerTask('markfailed', 'changestatus');
  }

  public function changePaid()
  {
    $app   = JFactory::getApplication();
    $batch = $app->input->post->get('cid', array(), 'array');
    $model = $this->getModel('Order');
    $task  = $this->getTask();
    $value = intval('markpaid' == $task);

    if ($model->changePaid($batch, $value)) {
      $msg = FactoryText::plural('list_'.$task.'_success', count($batch));
    } else {
      $msg = FactoryText::_('list_'.$task.'_error');

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'error');
      }
    }

    $this->setRedirect(FactoryRoute::view('orders'), $msg);
  }

  public function changeStatus()
  {
    $app   = JFactory::getApplication();
    $batch = $app->input->post->get('cid', array(), 'array');
    $model = $this->getModel('Order');
    $task  = $this->getTask();
    $value = 'markcomplete' == $task ? 20 : 30;

    if ($model->changeStatus($batch, $value)) {
      $msg = FactoryText::plural('list_'.$task.'_success', count($batch));
    } else {
      $msg = FactoryText::_('list_'.$task.'_error');

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'error');
      }
    }

    $this->setRedirect(FactoryRoute::view('orders'), $msg);
  }

  public function delete()
  {
    $app   = JFactory::getApplication();
    $batch = $app->input->post->get('cid', array(), 'array');
    $model = $this->getModel('Order');

    if ($model->delete($batch)) {
      $msg = FactoryText::plural('list_delete_success', count($batch));
    } else {
      $msg = FactoryText::_('list_delete_error');

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'error');
      }
    }

    $this->setRedirect(FactoryRoute::view('orders'), $msg);
  }
}
