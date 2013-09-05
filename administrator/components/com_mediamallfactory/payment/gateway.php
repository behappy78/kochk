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

abstract class FactoryPaymentGateway
{
  protected $element;
  protected $classOrder = null;
  protected $classPayment = null;
  protected $order = null;
  protected $urls = array();
  protected $params;
  protected $logo;
  protected $purchase_logo;
  protected $redirects = false;

  const STATUS_PENDING      = 10;
  const STATUS_COMPLETED    = 20;
  const STATUS_FAILED       = 30;
  const STATUS_MANUAL_CHECK = 40;

  abstract public function step1($data);

  abstract public function processNotification();

  public function __construct($element, $config = array())
  {
    $this->element = $element;

    if (isset($config['order'])) {
      $this->classOrder = $config['order'];
    }

    if (isset($config['payment'])) {
      $this->classPayment = $config['payment'];
    }

    if (isset($config['gateway'])) {
      $this->params        = $config['gateway']->params;
      $this->logo          = $config['gateway']->logo;
      $this->purchase_logo = $config['gateway']->purchase_logo;
    }

    $this->urls['complete'] = FactoryRoute::view('payment&layout=completed');
    $this->urls['cancel']   = FactoryRoute::view('payment&layout=failed');
    $this->urls['notify']   = JURI::base().'components/com_mediamallfactory/payment.php?method=' . $this->element;

    // Load language file.
    FactoryApplication::getInstance()->loadLanguage('site', $this->element);
  }

  public static function getInstance($element, $config = array())
  {
    static $instances = array();

    if (!isset($instances[$element])) {
      $instances[$element] = null;
      $class = 'FactoryPaymentGateway' . ucfirst($element);

      if (!class_exists($class)) {
        jimport('joomla.filesystem.file');
        $file = FactoryApplication::getInstance()->getPath('payment_gateways').DS.$element.DS.$element.'.php';

        if (JFile::exists($file)) {
          require_once $file;
        }
      }

      if (class_exists($class)) {
        $instances[$element] = new $class($element, $config);
      }
    }

    return $instances[$element];
  }

  public function execute($step, $data)
  {
    $method = 'step' . intval($step);

    if (!method_exists($this, $method)) {
      throw new Exception(FactoryText::sprintf('payment_gateway_error_step_not_exists', $this->element, $step), 500);
    }

    $this->$method($data);
  }

  public function notify()
  {
    $notification = $this->processNotification();

    if (!$notification instanceof FactoryPaymentNotification) {
      return false;
    }

    $notification->setGateway($this->element);

    $errors = $this->classOrder->getErrorsForNotification($notification);
    $status = count($errors) ? self::STATUS_MANUAL_CHECK : self::STATUS_COMPLETED;

    if (in_array($notification->getGatewayStatus(), array(self::STATUS_PENDING, self::STATUS_FAILED))) {
      $notification->setStatus($notification->getGatewayStatus());
    } elseif (self::STATUS_MANUAL_CHECK == $status || self::STATUS_MANUAL_CHECK == $notification->getGatewayStatus()) {
      $notification->setStatus(self::STATUS_MANUAL_CHECK);
    } else {
      $notification->setStatus(self::STATUS_COMPLETED);
    }

    $notification->setErrors(array_merge($errors, $notification->getGatewayErrors()));

    // Save payment.
    $this->classPayment->saveNotification($notification);

    header('Status: 200');

    $this->redirects($notification);

    return true;
  }

  public function render($template = 'default')
  {
    jimport('joomla.filesystem.file');
    $src = FactoryApplication::getInstance()->getPath('payment_gateways').DS.$this->element.DS.'templates'.DS.$template.'.php';

    if (!JFile::exists($src)) {
      throw new Exception(FactoryText::_('payment_gateway_error_template_not_found', 500));
    }

    require_once $src;

    return true;
  }

  public function getOrder($var = null)
  {
    return isset($this->order->$var) ? $this->order->$var : null;
  }

  public function getLogo()
  {
    jimport('joomla.filesystem.folder');
    $folder = FactoryApplication::getInstance()->getPath('payment_gateways').DS.$this->element.DS.'images';

    if (JFolder::exists($folder)) {
      $files = JFolder::files($folder, $this->element);

      if ($files) {
        return JURI::root().'administrator/components/com_mediamallfactory/payment/gateways/'.$this->element.'/images/'.$files[0];
      }
    }

    return $this->logo;
  }

  public function getPurchaseLogo()
  {
    jimport('joomla.filesystem.folder');
    $folder = FactoryApplication::getInstance()->getPath('payment_gateways').DS.$this->element.DS.'images';

    if (JFolder::exists($folder)) {
      $files = JFolder::files($folder, $this->element);

      if ($files) {
        return JURI::root().'administrator/components/com_mediamallfactory/payment/gateways/'.$this->element.'/images/'.$files[0];
      }
    }

    return $this->purchase_logo;
  }

  public function getForm($form, $data = array(), $nextStep = null, $options = array())
  {
    $data['step'] = $nextStep;

    FactoryHtml::stylesheet('edit');
    FactoryForm::addFormPath(FactoryApplication::getInstance()->getPath('payment_gateways').DS.$this->element.DS.'forms');
    FactoryForm::addFieldPath(FactoryApplication::getInstance()->getPath('payment_gateways').DS.$this->element.DS.'forms');
    FactoryForm::addRulePath(FactoryApplication::getInstance()->getPath('payment_gateways').DS.$this->element.DS.'forms');

    if (!isset($options['control'])) {
      $options['control'] = 'purchasecredits';
    }

    $form = FactoryForm::getInstance($form, $form, $options);

    $form->load('<form><fieldset name="details"><field name="step" type="hidden" /><field name="method" type="hidden" /><field name="credits" type="hidden" /></fieldset></form>');

    $form->bind($data);

    return $form;
  }

  public function redirectStep($step, $data, $errors = array())
  {
    $app = JFactory::getApplication();

    foreach ($errors as $error) {
      $app->enqueueMessage($error->toString(), 'error');
    }

    $app->redirect(FactoryRoute::task('purchasecredits.purchase&purchasecredits[method]=' . $data['method'] . '&purchasecredits[step]=' . $step));
  }

  protected function redirects($notification)
  {
    if (!$this->redirects) {
      return false;
    }

    $app = JFactory::getApplication();
    switch ($notification->getStatus()) {
      case self::STATUS_COMPLETED:
        $url = FactoryRoute::view('payment&layout=completed');
        break;

      case self::STATUS_FAILED:
        $url = FactoryRoute::view('payment&layout=failed');
        break;
    }

    foreach ($notification->getErrors() as $error) {
      $app->enqueueMessage($error, 'error');
    }

    $url = str_replace('components/com_mediamallfactory/', '', $url);

    $app->redirect($url);
  }

  protected function createOrder($data)
  {
    if (!$this->classOrder) {
      throw new Exception(FactoryText::_('payment_gateway_error_order_class_not_found'));
    }

    if (false == $this->order = $this->classOrder->create($data)) {
      throw new Exception(FactoryText::_('payment_gateway_error_order_not_created'));
    }

    return $this->order;
  }

  protected function getParam($param, $default = null)
  {
    return $this->params->get($param, $default);
  }

  protected function getUrl($type)
  {
    return isset($this->urls[$type]) ? $this->urls[$type] : null;
  }

  protected function getNewPaymentNotification()
  {
    return new FactoryPaymentNotification();
  }
}
