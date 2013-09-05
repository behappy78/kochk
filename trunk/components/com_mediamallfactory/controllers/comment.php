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

class MediaMallFactoryFrontendControllerComment extends JController
{
  public function vote()
  {
    $input    = JFactory::getApplication()->input;
    $model    = $this->getModel('Comment');
    $response = array();

    $comment_id = $input->post->getInt('comment_id', 0);
    $vote       = $input->post->getInt('vote', 1);

    if ($model->vote($comment_id, $vote)) {
      $response['status']  = 1;
      $response['message'] = FactoryText::_('comment_vote_success');
      $response['votes_up'] = $model->getState('votes_up');
      $response['votes_down'] = $model->getState('votes_down');
    } else {
      $response['status']  = 0;
      $response['message'] = FactoryText::_('comment_vote_error');
      $response['error']   = $model->getError();
    }

    echo json_encode($response);

    jexit();
  }

  public function save()
  {
    $app      = JFactory::getApplication();
    $data     = JFactory::getApplication()->input->post->get('comment', array(), 'array');
    $model    = $this->getModel('Comment');
    $option   = FactoryApplication::getInstance()->getOption();
    $name     = 'comment';

    if ($model->save($data)) {
      $msg = FactoryText::_('comment_save_success');

      $app->setUserState($option.'.edit.'.$name.'.data', null);
    } else {
      $msg = FactoryText::_('comment_save_error');

      $app->setUserState($option.'.edit.'.$name.'.data', $data);

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'warning');
      }
    }

    $this->setRedirect(FactoryRoute::view('media&media_id=' . $data['media_id']), $msg);
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
