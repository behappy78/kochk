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

JFormHelper::loadFieldType('List');

class JFormFieldMediaMallFactoryCurrency extends JFormFieldList
{
  public $type = 'MediaMallFactoryCurrency';

  protected function getOptions()
  {
    jimport('joomla.filesystem.folder');

    $options = array();
    $db =& JFactory::getDBO();
    $query = $db->getQuery(true);
    $query->select('id, hits, currency, iso4217, currency_symbol');
    $query->from('#__countries'); 
    $query->where('published = 1');
    $query->order('hits DESC');
    $db->setQuery($query);
    if ($db->getErrorNum()) {
    echo $db->getErrorMsg();
    }
    $results = $db->loadObjectList();
    //echo $country;
    if ($results) {
        foreach ($results as $result) {
            $options[$result->id] = $result->currency;
        }
    }      
    return $options;
  }
}
