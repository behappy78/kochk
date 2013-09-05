<?php
defined('_JEXEC') or die('Access Deny');
class plgUserKochk_Plg extends JPlugin
{
	function onUserLogin($user,$options=array()){
		$menu_id=$this->params->get('menu_id');
		$app=JFactory::getApplication();
		$menu=$app->getMenu();
		$item=$menu->getItem($menu_id);
		$url=JRoute::_($item->link.'&itemId='.$menu_id);
		$app->redirect($url,'Login Sucessfully and you are redirecting to admin specific page');
	}
}