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

class MediaMallFactoryFrontendModelPurchaseCredits extends JModel
{
  protected $form_name = 'purchasecredits';
  protected $bonuses   = null;

  public function getForm()
  {
		// Get the form.
  	$form = FactoryForm::getInstance($this->form_name, $this->form_name, array('control' => $this->form_name));

    // Create profile.
    $model = JModel::getInstance('EditProfile', 'MediaMallFactoryFrontendModel');
    $model->getItem();

		return $form;
  }

  public function getBonuses()
  {
    if (is_null($this->bonuses)) {
      $dbo   = $this->getDbo();
      $query = $dbo->getQuery(true)
        ->select('b.*')
        ->from('#__mediamallfactory_credits_bonuses b')
        ->where('b.published = ' . $dbo->quote(1))
        ->order('b.credits ASC');

      $this->bonuses = $dbo->setQuery($query)
        ->loadObjectList();
    }

    return $this->bonuses;
  }

  public function getGateway($element)
  {
    $table = FactoryTable::getInstance('PaymentGateway');
    $table->load(array('element' => $element, 'published' => 1));

    if ($element != $table->element) {
      return false;
    }

    $gateway = FactoryPaymentGateway::getInstance($table->element, array(
      'order'      => FactoryTable::getInstance('Order'),
      'payment'    => FactoryTable::getInstance('Payment'),
      'dispatcher' => JDispatcher::getInstance(),
      'gateway'    => $table,
    ));

    return $gateway;
  }

  public function notify()
  {
    $input = JFactory::getApplication()->input;
    $method = $input->get->getCmd('method', '');

    $gateway = $this->getGateway($method);

    if (!$gateway) {
      return false;
    }

    return $gateway->notify();
  }
}
