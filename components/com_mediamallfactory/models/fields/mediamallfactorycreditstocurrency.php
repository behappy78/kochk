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

class JFormFieldMediaMallFactoryCreditsToCurrency extends JFormField
{
  public $type = 'MediaMallFactoryCreditsToCurrency';

  protected function getInput()
  {
    FactoryHtml::script('fields/creditstocurrency');

    $rate = FactoryApplication::getInstance()->getParam('general.credits.credits_rate', 0.5);
    $credits = $this->formControl.'_'.(string)$this->element['credits'];

    $html = array();

    $html[] = '<div style="padding-top: 5px;">';
    $html[] = '<span class="mediamallfactorycreditstocurrency" data-rate="'.$rate.'" data-credits="'.$credits.'">0</span>';
    $html[] = FactoryApplication::getInstance()->getParam('general.currency.label', 'EUR');
    $html[] = '</div>';

    return implode("\n", $html);
  }
}
