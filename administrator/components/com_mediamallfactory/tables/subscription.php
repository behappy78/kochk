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

class MediaMallFactoryTableSubscription extends FactoryTable
{
  public function __construct(&$db)
  {
    parent::__construct('#__mediamallfactory_subscription', 'id', $db);
  }

  public function create($data)
  {
    if (!isset($data['credits']) || !isset($data['method'])) {
      throw new Exception(FactoryText::_('order_error_data_invalid'), 500);
    }

    $bonus = $this->getBonus($data['credits']);
    $registry = new JRegistry();
    $registry->set('credits', $data['credits']);
    $registry->set('bonus', $bonus);

    $this->title    = FactoryText::plural('order_title_credits', $data['credits']);
    $this->amount   = $data['credits'] * FactoryApplication::getInstance()->getParam('general.credits.credits_rate', 0.5);
    $this->currency = FactoryApplication::getInstance()->getParam('general.currency.label', 'EUR');
    $this->user_id  = JFactory::getUser()->id;
    $this->gateway  = $data['method'];
    $this->params   = $registry->toString();
    $this->status   = 10;

    if ($bonus) {
      $this->title .= ' ' . FactoryText::plural('order_title_bonus', $bonus);
    }

    if (!$this->store()) {
      return false;
    }

    $this->full_amount = $this->getAmount();

    return $this;
  }

  public function getAmount()
  {
    return $this->amount . ' ' . $this->currency;
  }

  public function getErrorsForNotification(FactoryPaymentNotification $notification)
  {
    $errors = array();

    // Find user.
    $table = FactoryTable::getInstance('Profile');
    $table->load($notification->getUserId());

    if ($table->user_id != $notification->getUserId()) {
      $errors[] = FactoryText::_('notification_validation_error_user_not_found');
    }

    // Find order.
    $table = FactoryTable::getInstance('Order');
    $table->load($notification->getOrderId());

    if ($table->id != $notification->getOrderId()) {
      $errors[] = FactoryText::_('notification_validation_error_order_not_found');
    } else {
      // Check amount.
      if ($table->amount != $notification->getAmount()) {
        FactoryText::_('notification_validation_error_amount_received');
      }

      // Check currency.
      if ($table->currency != $notification->getCurrency()) {
        FactoryText::_('notification_validation_error_currency');
      }

      // Check if order has already been marked as Completed or Failed.
      if (in_array($table->status, array(20, 30))) {
        FactoryText::_('notification_validation_error_order_already_processed');
      }

      // Check gateway.
      if ($table->gateway != $notification->getGateway()) {
        FactoryText::_('notification_validation_error_payment_gateway');
      }
    }


    return $errors;
  }

  public function getTotalCredits()
  {
    $credits = $this->params->get('credits', 0) + $this->params->get('bonus', 0);

    return $credits;
  }

  public function changePaid($state, $paymentId = null)
  {
    $this->paid       = $state;
    $this->payment_id = $paymentId;

    return $this->store();
  }

  public function changeStatus($state)
  {
    $this->status = $state;

    return $this->store();
  }

  protected function getBonus($credits)
  {
    $model = JModel::getInstance('PurchaseCredits', 'MediaMallFactoryFrontendModel');
    $bonus = 0;

    foreach ($model->getBonuses() as $item) {
      if ($item->credits < $credits) {
        $bonus = $item->bonus;
      }
    }

    return $bonus;
  }
}
