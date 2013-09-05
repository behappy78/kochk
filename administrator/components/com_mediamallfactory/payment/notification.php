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

class FactoryPaymentNotification
{
  protected $user_id;
  protected $amount;
  protected $currency;
  protected $order_id;
  protected $reference;
  protected $errors;
  protected $status;
  protected $gateway_status;
  protected $gateway_errors;
  protected $gateway;
  protected $request;

  public function __construct()
  {
    $this->setRequest(JRequest::get('request'));
  }

  public function setUserId($user_id)
  {
    $this->user_id = $user_id;
  }

  public function getUserId()
  {
    return $this->user_id;
  }

  public function setAmount($amount)
  {
    $this->amount = $amount;
  }

  public function getAmount()
  {
    return $this->amount;
  }

  public function setCurrency($currency)
  {
    $this->currency = $currency;
  }

  public function getCurrency()
  {
    return $this->currency;
  }

  public function setOrderId($order_id)
  {
    $this->order_id = $order_id;
  }

  public function getOrderId()
  {
    return $this->order_id;
  }

  public function setReference($reference)
  {
    $this->reference = $reference;
  }

  public function getReference()
  {
    return $this->reference;
  }

  public function setGatewayStatus($status)
  {
    $this->gateway_status = $status;
  }

  public function getGatewayStatus()
  {
    return $this->gateway_status;
  }

  public function setGatewayErrors($errors)
  {
    $this->gateway_errors = is_array($errors) ? $errors : array($errors);
  }

  public function getGatewayErrors()
  {
    return $this->gateway_errors;
  }

  public function setStatus($status)
  {
    $this->status = $status;
  }

  public function getStatus()
  {
    return $this->status;
  }

  public function setErrors($errors)
  {
    $this->errors = is_array($errors) ? $errors : array($errors);
  }

  public function getErrors()
  {
    return $this->errors;
  }

  public function setGateway($gateway)
  {
    $this->gateway = $gateway;
  }

  public function getGateway()
  {
    return $this->gateway;
  }

  public function setRequest($request)
  {
    $this->request = $request;
  }

  public function getRequest()
  {
    return $this->request;
  }
}
