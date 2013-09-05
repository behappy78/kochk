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

abstract class MediaMallFactoryFrontendControllerAdminMessage extends JController
{
  abstract protected function getRedirect($data);

  public function save()
  {
    $app   = JFactory::getApplication();
    $data  = $app->input->post->get('adminmessage', array(), 'array');
    $model = $this->getModel($this->getControllerName());

    $data = $this->prepareData($data);

    if ($model->save($data)) {
      $msg = FactoryText::_('adminmessage_save_success');
    } else {
      $msg = FactoryText::_('adminmessage_save_error');

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'warning');
      }
    }

    $this->setRedirect($this->getRedirect($data), $msg);
  }

  protected function getControllerName()
	{
    if (!preg_match('/(.*)Controller(.*)/i', get_class($this), $r)) {
      JError::raiseError(500, JText::_('JLIB_APPLICATION_ERROR_CONTROLLER_GET_NAME'));
    }

    return strtolower($r[2]);
	}

  protected function prepareData($data)
  {
    return $data;
  }

  public function authorise($task)
  {
    if (!parent::authorise($task)) {
      return false;
    }

    $permissions = array(
      'save' => array('logged'),
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
