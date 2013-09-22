<?php 

/**------------------------------------------------------------------------
com_mediamallfactory - Media Mall Factory 3.3.5 
------------------------------------------------------------------------
 * @author Feki Hichem
 * @copyright Copyright (C) 2013 Feki Hichem. All Rights Reserved.
  * Websites: http://www.culture3d.com
-------------------------------------------------------------------------*/

defined('_JEXEC') or die; 
$fields = JRequest::getVar('data');
$source = JRequest::getVar('src');
$db =& JFactory::getDBO();
switch ($source) {
    case 'email':
        verifEmail($fields, $db);
    break;
    case 'login':
        verifLogin($fields, $db);
    break;    
    default:
        ;
    break;
}

function verifEmail($fields, $db)
{
    $query = $db->getQuery(true);
    $query->select('id');
    $query->from('#__users'); 
    $query->where('email ='.$db->quote($fields));
    $db->setQuery($query);
    
    $results = $db->loadObjectList();
    //echo $query;
    if ($results) {
        echo '1';
      //echo $results[0]->id;
    }
    else 
        echo '0';
}

function verifLogin($fields, $db)
{
    $query = $db->getQuery(true);
    $query->select('id');
    $query->from('#__users'); 
    $query->where('username ='.$db->quote($fields));
    $db->setQuery($query);
    
    $results = $db->loadObjectList();
    //echo $query;
    if ($results) {
        echo '1';
      //echo $results[0]->id;
    }
    else 
        echo '0';
}
?>
