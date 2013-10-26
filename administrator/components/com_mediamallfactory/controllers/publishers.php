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

class MediaMallFactoryBackendControllerPublishers extends JController
{
  public function __construct($config = array())
  {
    parent::__construct($config);

    $this->registerTask('unpublish', 'publish');
  }

  public function publish()
  {
    $app   = JFactory::getApplication();
    $batch = $app->input->post->get('cid', array(), 'array');
    $model = $this->getModel('Category');
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

    $this->setRedirect(FactoryRoute::view('categories'), $msg);
  }
  public function add()
  {
    $level   = 1;
    //echo $level;
    //die();
    JFactory::getApplication()->redirect(JRoute::_('index.php?option=com_mediamallfactory&view=category&level='.$level, false));
  }
  public function edit()
  {
    $level   = 1;
    //echo $level;
    //die();
    JFactory::getApplication()->redirect(JRoute::_('index.php?option=com_mediamallfactory&view=category&level='.$level, false));
  }  
  public function delete()
  {
    $app   = JFactory::getApplication();
    $batch = $app->input->post->get('cid', array(), 'array');
    $model = $this->getModel('Category');

    if ($model->delete($batch)) {
      $msg = FactoryText::plural('list_delete_success', count($batch));
    } else {
      $msg = FactoryText::_('list_delete_error');

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'error');
      }
    }

    $this->setRedirect(FactoryRoute::view('categories'), $msg);
  }
}
