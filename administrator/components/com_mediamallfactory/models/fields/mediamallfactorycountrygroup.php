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

jimport('joomla.form.formfield');

class JFormFieldMediaMallFactoryCountryGroup extends JFormField
{
  public $type = 'MediaMallFactoryCountryGroup';

  protected function getInput()
  {

    $options = array();
    $db = JFactory::getDBO();
    $query = $db->getQuery(true);
    $query->select('iso3, fr');
    $query->from('#__countries'); 
    $query->order('hits DESC, fr');
    $db->setQuery($query);
    $results = $db->loadObjectList();
    $document = JFactory::getDocument();
    $document->addStyleSheet(JURI::base().'../includes/css/common.css');
    $document->addStyleSheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css');
    $document->addStyleSheet(JURI::base().'../includes/css/ui.multiselect.css');
    
    $document->addScript('https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js');
    $document->addScript('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js');
    $document->addScript(JURI::base().'../includes/js/plugins/localisation/jquery.localisation-min.js');
    $document->addScript(JURI::base().'../includes/js/plugins/scrollTo/jquery.scrollTo-min.js');
    $document->addScript(JURI::base().'../includes/js/ui.multiselect.js');
    
    
    
    /*$document->addScriptDeclaration('
    window.addEvent("domready", function(){
      new Sortables("#countriesd SELECT", {
        clone: true,
        revert: true,
        opacity: 0.7
      });
      });
    '); */
    $document->addScriptDeclaration("
		$(function(){
			$.localise('ui-multiselect', {language: 'fr', path:'". JURI::base()."../includes/js/locale/'});
			$('.multiselect').multiselect();
		});
    
    ");
 
    $output = '<div id="wrapper"><div id="content"><select id="countries" class="multiselect" multiple="multiple" name="group[countries][]">';
    $sels =  explode(',', $this->value);
    if ($results) {
        foreach ($results as $result) {
            if ($result->iso3){
                $select = '';
                foreach ($sels as $val)
                {
                    if ($val == $result->iso3)
                        $select = 'selected="selected"';
                }
                $output.= '<option '.$select.'value="'.$result->iso3.'" >'.$result->fr.'</option>';
            }
        }
    }   
    $output .= '</select></div></div>';
    //$output .= '<select multiple style="height:200px;" name="countries[]"></select></div>';   
    return $output;
  }
}
