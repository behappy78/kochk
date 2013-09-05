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

class JFormFieldMediaMallFactoryBonusCredits extends JFormField
{
  public $type = 'MediaMallFactoryBonusCredits';

  protected function getInput()
  {
    FactoryHtml::script('fields/bonuscredits');

    $model = JModel::getInstance('PurchaseCredits', 'MediaMallFactoryFrontendModel');
    $bonuses = $model->getBonuses();

    $array = array();
    foreach ($bonuses as $bonus) {
      $temp = array();
      $temp['credits'] = $bonus->credits;
      $temp['bonus']   = $bonus->bonus;

      $array[] = $temp;
    }

    $document = JFactory::getDocument();
    $document->addScriptDeclaration('Joomla._mediamallfactory_bonuses = ' . json_encode($array));

    $html = array();

    $html[] = '<div id="credits_bonus" style="padding-top: 5px;">0</div>';

    return implode("\n", $html);
  }
}
