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

jimport('joomla.application.component.model');

class MediaMallFactoryFrontendModelComment extends JModel
{
  public function getForm($loadData = true)
  {
		// Get the form.
  	$form = FactoryForm::getInstance('comment', 'comment', array('control' => 'comment'));

    if ($loadData) {
      $data = $this->loadFormData();
    } else {
      $data = array();
    }

    $form->bind($data);

		return $form;
  }

  public function vote($comment_id, $vote = 1, JUser $user = null)
  {
    // Initialise variables.
    if (is_null($user)) {
      $user = JFactory::getUser();
    }

    // Check if user is not guest.
    if ($user->guest) {
      $this->setError(FactoryText::_('comment_vote_error_guest'));
      return false;
    }

    // Load the comment.
    $table = JTable::getInstance('Comment', 'MediaMallFactoryTable');
    $table->load($comment_id);

    // Check if comment exists.
    if ($comment_id != $table->id) {
      $this->setError(FactoryText::_('comment_vote_error_comment_not_found'));
      return false;
    }

    // Check if user is voting on own comment.
    if ($table->user_id == $user->id) {
      $this->setError(FactoryText::_('comment_vote_error_cannot_vote_own_review'));
      return false;
    }

    // Load current user vote
    $comment_vote = JTable::getInstance('CommentVote', 'MediaMallFactoryTable');
    $comment_vote->load(array('user_id' => $user->id, 'comment_id' => $comment_id));

    if ($comment_vote->id) {
      if ($comment_vote->vote == 1) {
        $table->votes_up--;
      } else {
        $table->votes_down--;
      }
    } else {
      $comment_vote->user_id = $user->id;
      $comment_vote->comment_id = $comment_id;
    }

    $comment_vote->vote = $vote;
    $comment_vote->store();

    if ($vote == 1) {
      $table->votes_up++;
    } else {
      $table->votes_down++;
    }

    $table->store();

    $this->setState('votes_up', $table->votes_up);
    $this->setState('votes_down', $table->votes_down);

    return true;
  }

  public function save($data)
  {
    // Initialise variables.
    $form   = $this->getForm(false);
    $data   = $form->filter($data);
		$return = $form->validate($data);

    // Check if form is valid.
    if (!$return) {
      foreach ($form->getErrors() as $message) {
				$this->setError(JText::_($message));
			}

      return false;
    }

    // Get media.
    $media = FactoryTable::getInstance('Media');
    $media->load($data['media_id']);

    // Check if user is allowed to add review.
    if (!$media->isAllowedAddReview()) {
      $this->setError($media->getError());
      return false;
    }

    // Save the review.
    $table = FactoryTable::getInstance('Comment');
    if (!$table->save($data)) {
      $this->setError($table->getError());
      return false;
    }

    // Update the media vote.
    $media->updateRating($table->rating);

    return true;
  }

  protected function loadFormData()
  {
    // Check the session for previously entered form data.
    $name   = $this->getName();
    $option = FactoryApplication::getInstance()->getOption();

    $data = JFactory::getApplication()->getUserState($option.'.edit.'.$name.'.data', array());

    if (!isset($data['media_id']) || !$data['media_id']) {
      $data['media_id'] = JFactory::getApplication()->input->get->getInt('media_id', 0);
    }

    return $data;
  }
}
