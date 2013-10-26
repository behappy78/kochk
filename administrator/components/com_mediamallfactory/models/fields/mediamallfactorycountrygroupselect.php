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

class JFormFieldMediaMallFactoryCountryGroupSelect extends JFormFieldList
{
  public $type = 'MediaMallFactoryCountryGroupSelect';

  protected function getOptions()
  {
    $options = array();
    $db = JFactory::getDBO();
    $query = $db->getQuery(true);
    $query->select('id, title');
    $query->from('#__mediamallfactory_groups'); 
    //$query->where('published = 1');
    $query->order('hits desc, id ASC');
    $db->setQuery($query);
    $results = $db->loadObjectList();
    //echo $country;
    if ($results) {
        foreach ($results as $result) {
            $options[$result->id] = $result->title;
        }
    }      
    return $options;
  }
}
