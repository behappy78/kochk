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

class JFormFieldMediaMallFactoryCategory extends JFormFieldList
{
  public $type = 'MediaMallFactoryCurrency';

  protected function getOptions()
  {
    $jinput = JFactory::getApplication()->input;
    jimport('joomla.filesystem.folder');
    $db = JFactory::getDBO();
    /*
    if ($this->element['parentonly'])
        $parent = (string)$this->element['parentonly'];
    else */
        $parent = 'false';

        /*
    if ($this->element['excludecurrent'])
        $excurrent = (string)$this->element['excludecurrent'];
    else 
        $excurrent = 'false';
        */
    $excurrent = 'true';
        
    $where1 = '';
    if ($excurrent == 'true')
    {
        $current = (int) $jinput->get('id','0');
    }
    else 
        $current = 0;
    if ($this->element['level'])
        $level = (int)$this->element['level'];
    else 
        $level = 0;

    $where = " AND level =".($level);
    $options = array();
    
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__mediamallfactory_category');
    if ($current != 0)
        $query->where('parent_id != '.$db->quote($current));

    $query->where('published = 1'.$where);
    if ($parent == "true")
        $query->where('parent_id = 0');
    $query->order('id asc');
    $db->setQuery($query);
    if ($db->getErrorNum()) {
    echo $db->getErrorMsg();
    }
    $results = $db->loadObjectList();
    $options[0] = "";        
    if ($results) {
        foreach ($results as $result) {
            if ($result->id != $current)
                $options[$result->id] = $result->title;
        }
    }
     
    return $options;
  }
}
