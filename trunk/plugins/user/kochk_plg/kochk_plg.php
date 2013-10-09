<?php
defined('_JEXEC') or die('Access Deny');
class plgUserKochk_Plg extends JPlugin
{
	function onUserLogin($user, $options=array()){
	    $origpage = "redirected";
        $app=JFactory::getApplication();	    
	    $uri = JURI::getInstance();
        $myabsoluteurl = $uri->toString(array('path'));
        if (JFactory::getApplication()->isSite())
        {
            $user = JFactory::getUser();
            $id = $user->id;
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);
            $query->select('*');
            $query->from('#__mediamallfactory_profiles'); 
            $query->where('user_id ='.(int)$id);
            //$query->where('profiled = 1');  
            $db->setQuery($query);
            if ($db->getErrorNum()) {
              echo $db->getErrorMsg();
            }
            $results = $db->loadObjectList();
            if (!$results) {
                $app=JFactory::getApplication();
                $url=JRoute::_(JURI::base()."index.php?option=com_mediamallfactory&view=registration");
                $app->redirect($url, "Please Complete your profile to continue");                                
                return false;
            }                  
            else
            {
                //print_r($results);
                if ($results[0]->profiled == 1)
                {
                    $app=JFactory::getApplication();
                    $url=JRoute::_(JURI::base()."index.php?option=com_mediamallfactory&view=registration");
                    $app->redirect($url, "Veuillez acheter un pack");
                }
                else 
                {
                    $app=JFactory::getApplication();
                    $url=JRoute::_(JURI::base()."index.php?option=com_mediamallfactory&view=registration");
                    $app->redirect($url);
                }         
            }
    	    $session =& JFactory::getSession();
        	if($session->has('origpage'))
            {
                $gets = array();
                $gets_array = $session->get('gets');
                if ($gets_array['task'] == 'purchase' AND $gets_array['type'] == 'media')
                {
                    $url=JRoute::_(JURI::base()."index.php?option=".$gets_array['option'].'&view=media&media_id='.$gets_array['media_id'].'&Itemid='.$gets_array['Itemid']);
                    $app->redirect($url, $url);
                }
                else 
                {
                    foreach ($session->get('gets') as $key => $val)
                    {
                        $gets[] = $key."=".$val;
                    }
                    $option = implode("&", $gets);
                    //print_r($session->get('gets'));
                    //die();
                    $url=JRoute::_(JURI::base()."index.php?".$option);
                    $session->clear( 'origpage');
                    $app->redirect($url, $url);
                }
            }
            else{
                return true;
                $ip = $_SERVER['REMOTE_ADDR'];
                include_once (JPATH_ROOT.DS.'includes'.DS.'geoiploc.php');
                $country = getCountryFromIP($ip, " NamE ");
                $origpage =  "U R from ".$country;
                $menu_id=$this->params->get('menu_id');
        		$menu=$app->getMenu();
        		$item=$menu->getItem($menu_id);
        		$url=JRoute::_($item->link.'&itemId='.$menu_id);
            }
        }
	}
	
}