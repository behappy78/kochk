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

class MediaMallFactoryTableInvoice extends FactoryTable
{
  public function __construct(&$db)
  {
    parent::__construct('#__mediamallfactory_invoices', 'id', $db);
  }

  public function createFromOrder($orderId)
  {
    // Get order.
    $order = FactoryTable::getInstance('Order');
    $order->load($orderId);

    // Check if order exists.
    if ($orderId != $order->id) {
      return false;
    }

    $vat_rate = FactoryApplication::getInstance()->getParam('invoices.global.vat_rate', 0);

    $params = new JRegistry();
    $params->set('seller_information', FactoryApplication::getInstance()->getParam('invoices.seller.template', 'Seller Information'));
    $params->set('buyer_information', $this->createBuyerTemplate($order->user_id));

    $this->user_id   = $order->user_id;
    $this->title     = $order->title;
    $this->params    = $params->toString();
    $this->amount    = $order->amount;
    $this->currency  = $order->currency;
    $this->vat_rate  = $vat_rate;
    $this->vat_value = $order->amount * ($vat_rate / 100);

    if (!$this->store()) {
      return false;
    }

    return $this;
  }

  protected function createBuyerTemplate($userId)
  {
    $profile = FactoryTable::getInstance('Profile');
    $profile->load($userId);

    $buyer_template = FactoryApplication::getInstance()->getParam('invoices.buyer.template');

    $search = array(
      '%%name%%',
      '%%address%%',
      '%%city%%',
      '%%country%%',
    );
    $replace = array(
      $profile->params->get('first_name') . ' ' . $profile->params->get('last_name'),
      $profile->params->get('address'),
      $profile->params->get('city'),
      $profile->params->get('country'),
    );

    return str_replace($search, $replace, $buyer_template);
  }
}
