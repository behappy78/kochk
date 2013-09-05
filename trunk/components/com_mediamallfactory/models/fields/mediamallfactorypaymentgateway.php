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

class JFormFieldMediaMallFactoryPaymentGateway extends JFormField
{
  public $type = 'MediaMallFactoryPaymentGateway';

  protected function getOptions()
  {
    $dbo = JFactory::getDbo();

    $query = $dbo->getQuery(true)
      ->select('p.element AS id, p.logo, p.title, p.params, p.purchase_logo')
      ->from('#__mediamallfactory_payment_gateways p')
      ->where('p.published = ' . $dbo->quote(1))
      ->order('p.ordering ASC');
    $results = $dbo->setQuery($query)
      ->loadObjectList();

    foreach ($results as &$result) {
      $gateway = FactoryPaymentGateway::getInstance($result->id, array(
        'gateway' => $result,
      ));

      $result->logo = $gateway->getLogo();
    }

    return $results;
  }

  protected function getInput()
	{
		// Initialize variables.
		$html = array();

		// Initialize some field attributes.
		$class = $this->element['class'] ? ' class="radio ' . (string) $this->element['class'] . '"' : ' class="radio"';

		// Start the radio field output.
		$html[] = '<div>';

		// Get the field options.
		$options = $this->getOptions();

    $html[] = '<fieldset id="' . $this->id . '"' . $class . '>';

		// Build the radio field output.
		foreach ($options as $i => $option) {
      $html[] = '<div class="payment-container radio" id="'.$this->id.'"><label for="' . $this->id . $i . '"' . $class . '>';
      $html[] = '<input type="radio" id="' . $this->id . $i . '" name="' . $this->name . '"' . ' value="' . htmlspecialchars($option->id, ENT_COMPAT, 'UTF-8') . '"' . $class . '/>';
      $html[] = '<img src="'.$option->logo.'" alt="' . JText::alt($option->title, preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)) . '" />';
      $html[] = '</label></div>';
		}

		// End the radio field output.
		$html[] = '</fieldset>';

		return implode($html);
	}
}
