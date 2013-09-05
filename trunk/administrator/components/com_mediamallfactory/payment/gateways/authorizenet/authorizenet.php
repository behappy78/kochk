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

class FactoryPaymentGatewayAuthorizeNet extends FactoryPaymentGateway
{
  protected $redirects = true;

  public function step1($data)
  {
    $this->form = $this->getForm('step1', $data, 2);

    return $this->render();
  }

  public function step2($data)
  {
    $form   = $this->getForm('step1');
    $data   = $form->filter($data);
    $return = $form->validate($data);

    // Check if form is valid.
    if (!$return) {
      $this->redirectStep(1, $data, $form->getErrors());
      return false;
    }

    // No errors found, create a new order
    $order = $this->createOrder($data);

    // Prepare post values for authorize.net
    $post_values = array(
      'x_login'		 => $this->getParam('api_login'),
      'x_tran_key' => $this->getParam('transaction_key'),

      'x_version'			   => '3.1',
      'x_delim_data'		 => 'TRUE',
      'x_delim_char'		 => '|',
      'x_relay_response' => 'FALSE',
      'x_test_request'   => $this->getParam('test_mode'),

      'x_type'		 => 'AUTH_CAPTURE',
      'x_method'	 => 'CC',
      'x_card_num' => $data['card_num'],
      'x_exp_date' => $data['exp_date'],

      'x_amount'			  => $order->amount,
      //'x_currency_code' => 'EUR',
      'x_description'   => $order->title,
      'x_invoice_num'   => $order->id,

      'x_first_name' => '',
      'x_last_name'	 => '',
      'x_address'		 => '',
      'x_state'			 => '',
      'x_zip'				 => ''
    );

    $post_string = "";
    foreach ($post_values as $key => $value) {
      $post_string .= "$key=" . urlencode($value) . "&";
    }
    $post_string = rtrim($post_string, "& ");

    $request = curl_init($this->getAction());
    curl_setopt($request, CURLOPT_HEADER, 0);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($request, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
    $post_response = curl_exec($request);
    curl_close ($request);

    // This line takes the response and breaks it into an array using the specified delimiting character
    $response_array = explode($post_values['x_delim_char'], $post_response);

    $this->_order = $order;
    $this->_ipn   = $response_array;

    $this->notify();
  }

  public function processNotification()
  {
    $ipn = $this->_ipn;
    $status = $this->getStatus($ipn);
    $errors = $this->getErrors($ipn);
    $notification = $this->getNewPaymentNotification();

    $notification->setUserId($this->_order->user_id);
    $notification->setAmount(stripslashes($ipn[9]));
    $notification->setCurrency($this->_order->currency);
    $notification->setOrderId($this->_order->id);
    $notification->setReference(stripslashes($ipn[6]));

    $notification->setGatewayErrors($errors);
    $notification->setGatewayStatus($status);

    return $notification;
  }

  protected function getErrors($ipn)
  {
    $errors = array();

    // Validate IPN
    if (1 !== stripslashes($ipn[0])) {
	    $errors[] = stripslashes($ipn[3]);
	  }

	  return $errors;
  }

  protected function getStatus($ipn)
  {
    $status = null;

    switch (stripslashes($ipn[0])) {
      case '1':
        $status = self::STATUS_COMPLETED;
        break;

      case '2':
      default:
        $status = self::STATUS_FAILED;
        break;

//      default:
//        $status = self::STATUS_PENDING;
//        break;
    }

    return $status;
  }

  protected function getAction()
  {
    if ($this->getParam('test_mode', 0)) {
      return $this->getParam('action_test', 'https://test.authorize.net/gateway/transact.dll');
    }

    return $this->getParam('action', 'https://secure.authorize.net/gateway/transact.dll');
  }
}
