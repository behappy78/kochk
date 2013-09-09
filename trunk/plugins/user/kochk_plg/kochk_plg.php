<?php
defined('_JEXEC') or die('Access Deny');
class plgUserKochk_Plg extends JPlugin
{
	function onUserLogin($user, $options=array()){
	    $origpage = "redirected";
        $app=JFactory::getApplication();	    
	    $uri = &JURI::getInstance();
        $myabsoluteurl = $uri->toString(array('path'));
        if (JFactory::getApplication()->isSite())
        {
    	    $session =& JFactory::getSession();
        	if($session->has('origpage'))
            {
                $origpage = "Page ".JRoute::_(JURI::base()."index.php?option=".$session->get('option')."&view=".$session->get('view'));
                $url=JRoute::_(JURI::base()."index.php?option=".$session->get('option')."&view=".$session->get('view'));
                $session->clear( 'origpage');
            }
            else{
                $ip = $_SERVER['REMOTE_ADDR'];
                include_once (JPATH_ROOT.DS.'includes'.DS.'geoiploc.php');
                $country = getCountryFromIP($ip, " NamE ");
                $origpage =  "U R from ".$country;
                $menu_id=$this->params->get('menu_id');
        		$menu=$app->getMenu();
        		$item=$menu->getItem($menu_id);
        		$url=JRoute::_($item->link.'&itemId='.$menu_id);
            }
    		$app->redirect($url, $origpage);
        }
	}
	
}