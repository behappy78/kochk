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

class JFormFieldMediaMallFactoryCurrencyToCredits extends JFormField
{
  public $type = 'MediaMallFactoryCurrencyToCredits';

  protected function getInput()
  {
    FactoryHtml::script('fields/currencytocredits');

    $rate = FactoryApplication::getInstance()->getParam('general.credits.credits_rate', 0.5);
    $amount = $this->formControl.'_'.(string)$this->element['currency'];

    $html = array();

    $html[] = '<div class="mediamallfactorycurrencytocredits" data-rate="'.$rate.'" data-amount="'.$amount.'" style="margin-top: 5px;">0</div>';

    return implode("\n", $html);
  }
}
