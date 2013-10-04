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
    case 'mailcode':
        verifCode($fields, $db);
    break;   
    
    case 'reset':
        $session =& JFactory::getSession();
        $session->clear('step');
        $session->clear('stepD');
        $session->clear('data_1');
        $session->clear('data_2');
        $session->clear('data_3');
        $session->clear('data_4');
        $session->clear('data_5');          
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

function verifCode($fields, $db)
{
    $session =& JFactory::getSession();
    /*
    $query = $db->getQuery(true);
    $query->select('id');
    $query->from('#__users'); 
    $query->where('username ='.$db->quote($fields));
    $db->setQuery($query);
    
    $results = $db->loadObjectList();
    //echo $query;*/
    $confcode = $session->get('confcode');
    if ($confcode ==  $fields) {
        echo '0';
      //echo $results[0]->id;
    }
    else 
         echo '1';
}
?>
