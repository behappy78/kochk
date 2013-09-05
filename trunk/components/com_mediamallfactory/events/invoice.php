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

class MediaMallFactoryEventInvoice extends JEvent
{
  public function onMediaMallFactoryOrderStatusChange($orderId, $status)
  {
    // Check if invoices are enabled.
    $enabled = FactoryApplication::getInstance()->getParam('invoices.global.enable', 0);
    if (!$enabled) {
      return true;
    }

    // Check if order is marked as completed.
    if (20 != $status) {
      return false;
    }

    $invoice = FactoryTable::getInstance('Invoice');

    if (!$invoice = $invoice->createFromOrder($orderId)) {
      return false;
    }

    // Trigger invoice issued event.
    FactoryApplication::getInstance()->trigger('invoiceIssued', array(
      $invoice->id, $invoice->user_id, $invoice->created_at
    ));

    return true;
  }
}
