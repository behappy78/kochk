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

class JFormFieldMediaMallFactoryCountry extends JFormFieldList
{
  public $type = 'MediaMallFactoryCountry';

  protected function getOptions()
  {
    jimport('joomla.filesystem.folder');
    
    $options = array();
    $db = JFactory::getDBO();
    $query = $db->getQuery(true);
    $query->select('iso3, fr');
    $query->from('#__countries'); 
    //$query->where('published = 1');
    $query->order('hits DESC');
    $db->setQuery($query);
    $results = $db->loadObjectList();
    //echo $country;
    if ($results) {
        foreach ($results as $result) {
            $options[$result->iso3] = $result->fr;
        }
    }      
    return $options;
  }
}