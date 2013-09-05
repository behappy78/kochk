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

class MediaMallFactoryFrontendModelWithdrawFunds extends JModel
{
  protected $form_name = 'withdraw';

  public function getForm()
  {
		// Get the form.
  	$form = FactoryForm::getInstance($this->form_name, $this->form_name, array('control' => $this->form_name));

    $form->bind($this->getData());

		return $form;
  }

  public function withdraw($data)
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

    $data['amount'] = (float)$data['amount'];

    // Check if there is another pending request.
    $request = $this->getRequest($data['user_id']);
    if ($request) {
      $this->setError(FactoryText::_('withdrawfunds_error_pending_request'));
      return false;
    }

    // Check if the withdrawn amount is valid.
    $min_amount = $this->getAmountMin();
    $profile = FactoryTable::getInstance('Profile');
    $profile->load($data['user_id']);

    if ($min_amount > $data['amount'] || $profile->getBalanceAvailable() < $data['amount']) {
      $this->setError(FactoryText::sprintf('withdrawfunds_error_request_amount_not_valid', $min_amount, $profile->balance_available));
      return false;
    }

    // Send the payment request.
    $table = FactoryTable::getInstance('PaymentRequest');
    if (!$table->save($data)) {
      $this->setError($table->getError());
      return false;
    }

    // Update user's available balance.
    $profile->updateBalanceAvailable(-1 * $table->amount);

    // Check if a message was attached.
    if (!empty($data['message'])) {
      $comment = FactoryTable::getInstance('AdminMessage');

      $comment->user_id  = $table->user_id;
      $comment->item_id  = $table->id;
      $comment->owner_id = $table->user_id;
      $comment->type     = 'payment_request';
      $comment->is_admin = 0;
      $comment->message  = $data['message'];

      $comment->store();
    }

    return true;
  }

  public function getRequest($user_id = null)
  {
    if (is_null($user_id)) {
      $user_id = JFactory::getUser()->id;
    }

    $table = JTable::getInstance('PaymentRequest', 'MediaMallFactoryTable');
    $table->load(array('user_id' => $user_id, 'status' => 0));

    if ($table->id) {
      return $table->id;
    }

    return false;
  }

  public function getAmountCurrent()
  {
    $table = FactoryTable::getInstance('Profile');
    $table->load(JFactory::getUser()->id);

    return $table->getBalanceAvailable();
  }

  public function getAmountMin()
  {
    return FactoryApplication::getInstance()->getParam('authors.global.min_amount_withdraw', 0);
  }

  protected function getData()
  {
    $table = JTable::getInstance('Profile', 'MediaMallFactoryTable');
    $table->load(JFactory::getUser()->id);

    return array('current' => $table->balance_available);
  }
}
