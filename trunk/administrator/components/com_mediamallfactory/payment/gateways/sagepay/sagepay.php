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

class FactoryPaymentGatewaySagePay extends FactoryPaymentGateway
{
  protected $redirects = true;

  public function step1($data)
  {
    $session = JFactory::getSession();
    $test = $session->get('sagepay.data', array());

    $this->form = $this->getForm('step1', $data, 2);

    $this->form->bind($test);
    $session->set('sagepay.data', null);

    return $this->render();
  }

  public function step2($data)
  {
    $form   = $this->getForm('step1', array(), null, array('control' => ''));
    $data   = $form->filter($data);
    $return = $form->validate($data);

    $session = JFactory::getSession();

    // Check if form is valid.
    if (!$return) {
      $session->set('sagepay.data', $data);

      $this->redirectStep(1, $data, $form->getErrors());
      return false;
    }

    $session->set('sagepay.data', null);

    // Create order.
    $order = $this->createOrder($data);

    // Create the crypt.
    $data['Crypt'] = $this->createCrypt($order, $data);
    $data['Vendor'] = $this->getParam('vendor_name');

    $form->loadFile('confirm');
    $form->bind($data);
    $this->form = $form;

    return $this->render('confirm');
  }

  public function processNotification()
  {
    $crypt     = JFactory::getApplication()->input->getString('crypt', '');
    $decrypted = $this->simpleXor($this->base64Decode($crypt), $this->getParam('encryption_password'));
    $variables = array();
    parse_str($decrypted, $variables);

    $ipn = new JRegistry($variables);
    $errors = $this->getErrors($ipn);
    $status = $this->getStatus($ipn, $errors);

    $notification = $this->getNewPaymentNotification();

    $notification->setAmount($ipn->get('Amount'));
    $notification->setOrderId($ipn->get('VendorTxCode'));
    $notification->setReference($ipn->get('VPSTxId'));

    $notification->setGatewayErrors($errors);
    $notification->setGatewayStatus($status);

    return $notification;
  }

  protected function createCrypt($order, $vars)
  {
    $strPost = 'VendorTxCode=' . $order->id;

    $strPost .= '&ReferrerID='  . $this->getParam('referer_id');
    $strPost .= '&Amount='      . $order->amount;
    $strPost .= '&Currency='    . $order->currency;
    $strPost .= '&Description=' . $order->title;

    $strPost .= '&SuccessURL=' . $this->getUrl('notify');
    $strPost .= '&FailureURL=' . $this->getUrl('notify');

    $strPost .= '&CustomerName='  . $vars['firstname'] . ' ' . $vars['surname'];
    $strPost .= '&CustomerEMail=' . JFactory::getUser($order->user_id)->email;
    $strPost .= '&VendorEMail='   . $this->getParam('confirmation_email', '');
    $strPost .= '&SendEMail='     . $this->getParam('send_email', '');
    $strPost .= '&eMailMessage='  . $this->getParam('email_message', '');

    // Billing Details:
    $strPost .= '&BillingFirstnames=' . $vars['firstname'];
    $strPost .= '&BillingSurname='    . $vars['surname'];
    $strPost .= '&BillingAddress1='   . $vars['address1'];

    if (strlen($vars['address2']) > 0) {
      $strPost .= '&BillingAddress2=' . $vars['address2'];
    }

    $strPost .= '&BillingCity='     . $vars['city'];
    $strPost .= '&BillingPostCode=' . $vars['postcode'];
    $strPost .= '&BillingCountry='  . $vars['country'];

    if (strlen($vars['state']) > 0) {
      $strPost .= '&BillingState=' . $vars['state'];
    }

    if (strlen($vars['phone']) > 0) {
      $strPost .= '&BillingPhone=' . $vars['phone'];
    }

    // Delivery Details:
    $strPost .= '&DeliveryFirstnames=' . $vars['firstname'];
    $strPost .= '&DeliverySurname='    . $vars['surname'];
    $strPost .= '&DeliveryAddress1='   . $vars['address1'];

    if (strlen($vars['address2']) > 0) {
      $strPost .= '&DeliveryAddress2=' . $vars['address2'];
    }

    $strPost .= '&DeliveryCity='     . $vars['city'];
    $strPost .= '&DeliveryPostCode=' . $vars['postcode'];
    $strPost .= '&DeliveryCountry='  . $vars['country'];

    if (strlen($vars['state']) > 0) {
      $strPost .= '&DeliveryState=' . $vars['state'];
    }

    if (strlen($vars['phone']) > 0) {
      $strPost .= '&DeliveryPhone=' . $vars['phone'];
    }

    // Basket
    $strPost .= '&Basket=' . '1:' . $order->title . ':1:' . $order->amount . ':0:' . $order->amount . ':' . $order->amount;

    $strPost .= '&AllowGiftAid='  . $this->getParam('allow_gift_aid', '');
    $strPost .= '&ApplyAVSCV2='   . $this->getParam('apply_avscv2', '');
    $strPost .= '&Apply3DSecure=' . $this->getParam('apply_3dsecure', '');

    $strCrypt = $this->base64Encode($this->SimpleXor($strPost, $this->getParam('encryption_password', '')));

    return $strCrypt;
  }

  protected function base64Encode($plain)
  {
    // Do encoding
    $output = base64_encode($plain);

    // Return the result
    return $output;
  }

  protected function base64Decode($scrambled)
  {
    // Fix plus to space conversion issue
    $scrambled = str_replace(" ","+",$scrambled);

    // Do encoding
    $output = base64_decode($scrambled);

    // Return the result
    return $output;
  }

  protected function simpleXor($InString, $Key)
  {
    // Initialise key array
    $KeyList = array();
    // Initialise out variable
    $output = "";

    // Convert $Key into array of ASCII values
    for($i = 0; $i < strlen($Key); $i++){
      $KeyList[$i] = ord(substr($Key, $i, 1));
    }

    // Step through string a character at a time
    for($i = 0; $i < strlen($InString); $i++) {
      // Get ASCII code from string, get ASCII code from key (loop through with MOD), XOR the two, get the character from the result
      // % is MOD (modulus), ^ is XOR
      $output.= chr(ord(substr($InString, $i, 1)) ^ ($KeyList[$i % strlen($Key)]));
    }

    // Return the result
    return $output;
  }

  protected function getAction()
  {
    switch ($this->getParam('mode', 0)) {
      case 0:
      default:
        $action = $this->getParam('action_live');
        break;

      case 1:
        $action = $this->getParam('action_test');
        break;

      case 2:
        $action = $this->getParam('action_simulator');
        break;
    }

    return $action;
  }

  protected function getStatus($ipn, $errors)
  {
    $status = null;

    switch ($ipn->get('Status')) {
      case 'OK':
        $status = self::STATUS_COMPLETED;
        break;

      default:
        $status = self::STATUS_FAILED;
        break;
    }

    return $status;
  }

  protected function getErrors($ipn)
  {
    $errors = array();

    $details = $ipn->get('StatusDetail');
    if ('Successfully Authorised Transaction' != $details) {
      $errors[] = $details;
    }

    return $errors;
  }
}
