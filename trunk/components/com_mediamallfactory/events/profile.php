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

class MediaMallFactoryEventProfile extends JEvent
{
  public function onMediaMallFactoryOrderStatusChange($orderId, $status)
  {
    if (20 != $status) {
      return false;
    }

    $order = FactoryTable::getInstance('Order');
    $order->load($orderId);

    if ($orderId != $order->id) {
      return false;
    }

    $credits = $order->getTotalCredits();
    $profile = FactoryTable::getInstance('Profile');

    $profile->load($order->user_id);

    if ($order->user_id != $profile->user_id) {
      return false;
    }

    if (!$profile->updateCredits($credits)) {
      return false;
    }

    // Trigger event.
    FactoryApplication::getInstance()->trigger('creditsUpdate', array(
      $credits,
      $order->user_id,
      'CreditsPurchase',
      array('order_id' => $order->id, 'payment_id' => $order->payment_id)
    ));

    return true;
  }

  public function onMediaMallFactoryPaymentRequestResolved($userId, $status, $amount)
  {
    $table = FactoryTable::getInstance('Profile');
    if (!$table->load($userId)) {
      return false;
    }

    if (!$table->syncBalance($status)) {
      return false;
    }

    // Trigger Balance Update event.
    if (1 == $status) {
      FactoryApplication::getInstance()->trigger('balanceUpdate', array(
        $amount, $userId, 'WithdrawnFunds'
      ));
    }

    return true;
  }
}
