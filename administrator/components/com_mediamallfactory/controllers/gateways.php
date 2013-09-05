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

class MediaMallFactoryBackendControllerGateways extends JController
{
  public function __construct($config = array())
  {
    parent::__construct($config);

    $this->registerTask('unpublish', 'publish');
    $this->registerTask('orderup',   'reorder');
    $this->registerTask('orderdown', 'reorder');
  }

  public function publish()
  {
    $app   = JFactory::getApplication();
    $batch = $app->input->post->get('cid', array(), 'array');
    $model = $this->getModel('Gateway');
    $task  = $this->getTask();
    $value = intval('publish' == $task);

    if ($model->publish($batch, $value)) {
      $msg = FactoryText::plural('list_'.$task.'_success', count($batch));
    } else {
      $msg = FactoryText::_('list_'.$task.'_error');

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'error');
      }
    }

    $this->setRedirect(FactoryRoute::view('gateways'), $msg);
  }

  public function reorder()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$ids = JRequest::getVar('cid', null, 'post', 'array');
		$inc = ($this->getTask() == 'orderup') ? -1 : +1;

		$model = $this->getModel('Gateway');
		if (!$model->reorder($ids, $inc)) {
			$msg = JText::sprintf('JLIB_APPLICATION_ERROR_REORDER_FAILED', $model->getError());
		} else {
			$msg = JText::_('JLIB_APPLICATION_SUCCESS_ITEM_REORDERED');
		}

    $this->setRedirect(FactoryRoute::view('gateways'), $msg);
	}

  public function saveorder()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Get the input
		$pks = JRequest::getVar('cid', null, 'post', 'array');
		$order = JRequest::getVar('order', null, 'post', 'array');

		// Sanitize the input
		JArrayHelper::toInteger($pks);
		JArrayHelper::toInteger($order);

		// Get the model
		$model = $this->getModel('Gateway');
		if (!$model->saveorder($pks, $order)) {
			$msg = JText::sprintf('JLIB_APPLICATION_ERROR_REORDER_FAILED', $model->getError());
		} else {
			$msg = JText::_('JLIB_APPLICATION_SUCCESS_ORDERING_SAVED');
		}

    $this->setRedirect(FactoryRoute::view('gateways'), $msg);
	}
}
