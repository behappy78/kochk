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

class FactoryPaymentGatewayMoneyBookers extends FactoryPaymentGateway
{
  public function step1($data)
  {
    $this->createOrder($data);

    return $this->render();
  }

  public function processNotification()
  {
    $ipn    = new JRegistry(JRequest::get('POST'));
    $errors = $this->getErrors($ipn);
    $status = $this->getStatus($ipn, $errors);

    $notification = $this->getNewPaymentNotification();

    $notification->setUserId($ipn->get('m_userid'));
    $notification->setAmount($ipn->get('mb_amount'));
    $notification->setCurrency($ipn->get('mb_currency'));
    $notification->setOrderId($ipn->get('m_itemnr'));
    $notification->setReference($ipn->get('mb_transaction_id'));

    $notification->setGatewayErrors($errors);
    $notification->setGatewayStatus($status);

    return $notification;
  }

  protected function getStatus($ipn, $errors)
  {
    $status = null;

    switch ($ipn->get('payment_status')) {
      case '2':
        $status = count($errors) ? self::STATUS_MANUAL_CHECK : self::STATUS_COMPLETED;
        break;

      case '-1':
      case '-2':
      case '-3':
        $status = self::STATUS_FAILED;
        break;

      case '0':
      default:
        $status = self::STATUS_PENDING;
        break;
    }

    return $status;
  }

  protected function getErrors($ipn)
  {
    $errors = array();

    // Validate IPN
    if (true !== $this->validateIpn($ipn)) {
	    $errors[] = JText::_('IPN not verified');
	  }

	  // Validate moneybookers email
	  if ($ipn->get('email') != $this->getParam('email')) {
	    $errors[] = JText::_('Receiver email is different from expected');
	  }

	  return $errors;
  }

  protected function validateIpn($ipn)
  {
    $pay_to_email    = $ipn->get('receiver_email');
    $md5sig          = $ipn->get('md5sig');
    $mbooker_address = $this->getParam('email');
    $payment_status  = $ipn->get('status');

    $verified_ok = (strtolower($mbooker_address) == strtolower($pay_to_email) && $payment_status == '2');

    return $verified_ok;
  }
}
