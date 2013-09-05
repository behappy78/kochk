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

class FactoryPaymentGatewayPaypal extends FactoryPaymentGateway
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

    $notification->setUserId($ipn->get('option_selection1'));
    $notification->setAmount($ipn->get('mc_gross'));
    $notification->setCurrency($ipn->get('mc_currency'));
    $notification->setOrderId($ipn->get('item_number'));
    $notification->setReference($ipn->get('txn_id'));

    $notification->setGatewayErrors($errors);
    $notification->setGatewayStatus($status);

    return $notification;
  }

  protected function getStatus($ipn, $errors)
  {
    $status = null;

    switch ($ipn->get('payment_status')) {
      case 'Completed':
      case 'Processed':
        $status = count($errors) ? self::STATUS_MANUAL_CHECK : self::STATUS_COMPLETED;
        break;

      case 'Failed':
      case 'Denied':
      case 'Canceled-Reversal':
      case 'Expired':
      case 'Voided':
      case 'Reversed':
      case 'Refunded':
        $status = self::STATUS_FAILED;
        break;

      case 'In-Progress':
      case 'Pending':
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

	  // Validate paypal email
	  if ($ipn->get('receiver_email') != $this->getParam('email')) {
	    $errors[] = JText::_('Receiver email is different from expected');
	  }

	  return $errors;
  }

  protected function validateIpn()
  {
    // parse the paypal URL
    $url_parsed = parse_url($this->getAction());

    $post_string = '';
    foreach ($_POST as $field => $value)
    {
      $post_string .= $field . '=' . urlencode($value) . '&';
    }
    $post_string .= "cmd=_notify-validate";

    $fp = fsockopen('ssl://' . $url_parsed['host'], 443, $err_num, $err_str, 20);
    if (!$fp)
    {
      return 'Fsockopen error no. ' . $err_num . ': ' . $err_str . '. IPN not verified';
    }
    else
    {
      fputs($fp, "POST " . $url_parsed['path'] . " HTTP/1.1\r\n");
      fputs($fp, "Host: " . $url_parsed['host'] . ":443\r\n");
      fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
      fputs($fp, "Content-length: ".strlen($post_string)."\r\n");
      fputs($fp, "Connection: close\r\n\r\n");
      fputs($fp, $post_string . "\r\n\r\n");

      $response = '';
      while(!feof($fp))
      {
        $response .= fgets($fp, 1024);
      }

      fclose($fp);
    }

    if (preg_match('/VERIFIED/', $response))
    {
      return true;
    }

    return false;
  }

  protected function getAction()
  {
    if (!$this->getParam('sandbox', 0)) {
      return $this->getParam('action', 'https://www.paypal.com/cgi-bin/webscr');
    }

    return $this->getParam('action_sandbox', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
  }
}
