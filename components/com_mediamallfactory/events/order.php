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

class MediaMallFactoryEventOrder extends JEvent
{
  public function onMediaMallFactoryPaymentStatusChange($paymentId, $orderId, $paymentStatus)
  {
    /* @var $table MediaMallFactoryTableOrder */
    $table = FactoryTable::getInstance('Order');
    $table->load($orderId);

    if ($orderId != $table->id) {
      return false;
    }

    // Check if the order status is set to Pending.
    if (10 != $table->status) {
      return false;
    }

    $paymentStatus = intval(20 == $paymentStatus);
    $table->changePaid($paymentStatus, $paymentId);

    FactoryApplication::getInstance()->trigger('orderPaidChange', array(
      $table->id, $paymentStatus
    ));

    return true;
  }

  public function onMediaMallFactoryOrderPaidChange($orderId, $paymentStatus)
  {
    // Check payment status.
    if (0 == $paymentStatus) {
      return false;
    }

    /* @var $table MediaMallFactoryTableOrder */
    $table = FactoryTable::getInstance('Order');
    $table->load($orderId);

    if ($orderId != $table->id) {
      return false;
    }

    // Check if the order status is set to Pending.
    if (10 != $table->status) {
      return false;
    }

    $status = 20;
    $table->changeStatus($status);
    FactoryApplication::getInstance()->trigger('orderStatusChange', array(
      $table->id, $status
    ));
  }
}
