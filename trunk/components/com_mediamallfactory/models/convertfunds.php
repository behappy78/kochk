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

jimport('joomla.application.component.model');

class MediaMallFactoryFrontendModelConvertFunds extends JModel
{
  protected $form_name = 'convert';

  public function getForm()
  {
		// Get the form.
  	$form = FactoryForm::getInstance($this->form_name, $this->form_name, array('control' => $this->form_name));

    $form->bind($this->getData());

		return $form;
  }

  public function convert($data)
  {
    // Initialise variables.
    $form   = $this->getForm(false);
    $data   = $form->filter($data);
    $return = $form->validate($data);

    // Check if form is valid.
    if (!$return) {
      foreach ($form->getErrors() as $message) {
				$this->setError(JText::_($message));
			}

      return false;
    }

    $data['amount'] = (float)$data['amount'];

    // Check if the convert amount is valid.
    $min_amount = 1;
    $profile = FactoryTable::getInstance('Profile');
    $profile->load($data['user_id']);
    if ($min_amount > $data['amount'] || $profile->balance_available < $data['amount']) {
      $this->setError(FactoryText::sprintf('convertfunds_error_request_amount_not_valid', $min_amount, $profile->balance_available));
      return false;
    }

    // Update balance.
    $amount = -1 * $data['amount'];
    $profile->updateBalance($amount);

    // Trigger event.
    FactoryApplication::getInstance()->trigger('balanceUpdate', array(
      $amount, $profile->user_id, 'ConvertFunds'
    ));

    // Update credits.
    $rate = FactoryApplication::getInstance()->getParam('general.credits.credits_rate', 0.5);
    $credits = intval($data['amount'] / $rate);

    $profile->updateCredits($credits);

    // Trigger event.
    FactoryApplication::getInstance()->trigger('creditsUpdate', array(
      $credits, $profile->user_id, 'ConvertFunds'
    ));

    return true;
  }

  protected function getData()
  {
    $table = JTable::getInstance('Profile', 'MediaMallFactoryTable');
    $table->load(JFactory::getUser()->id);

    return array('current' => $table->balance_available);
  }
}
