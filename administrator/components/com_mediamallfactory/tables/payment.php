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

class MediaMallFactoryTablePayment extends FactoryTable
{
  public function __construct(&$db)
  {
    parent::__construct('#__mediamallfactory_payments', 'id', $db);
  }

  public function bindFromNotification(FactoryPaymentNotification $notification)
  {
    $registry = new JRegistry($notification->getErrors());

    $this->order_id    = $notification->getOrderId();
    $this->user_id     = $notification->getUserId();
    $this->amount      = $notification->getAmount();
    $this->currency    = $notification->getCurrency();
    $this->gateway     = $notification->getGateway();
    $this->refnumber   = $notification->getReference();
    $this->status      = $notification->getStatus();
    $this->errors      = $registry->toString();

    $registry = new JRegistry($notification->getRequest());
    $this->request = $registry->toString();
  }

  public function saveNotification(FactoryPaymentNotification $notification)
  {
    $this->bindFromNotification($notification);

    if (!$this->store()) {
      return false;
    }

    $event = $this->getName().'StatusChange';

    FactoryApplication::getInstance()
      ->trigger($event, array($this->id, $this->order_id, $this->status));

    return true;
  }

  public function changeStatus($state)
  {
    $this->status = $state;

    return $this->store();
  }
}
