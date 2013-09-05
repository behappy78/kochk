<?php

defined('_JEXEC') or die;

class MediaMallFactoryHelper
{
	public static function addSubmenu($view)
	{
    $app    = JFactory::getApplication();
    $option = 'com_mediamallfactory';
    JLoader::register('FactoryApplication', JPATH_ADMINISTRATOR.DS.'components'.DS.$option.DS.'libraries'.DS.'factory'.DS.'application.php');

    FactoryApplication::getInstance(array(
      'app'       => $app,
      'component' => 'MediaMallFactory',
      'option'    => $option,
    ));

    $items = array(
      'list',
      'users',
      'orders',
      'payments',
      'invoices',
      'requests',
      'configuration',
      'about',
    );

    if (JDEBUG) {
      //array_unshift($items, 'dashboard');
    }

    foreach ($items as $item) {
      if ('categories' == $item) {
        $link = JRoute::_('index.php?option=com_categories&extension=' . FactoryApplication::getInstance()->getOption());
      } else {
        $link = FactoryRoute::view($item);
      }
      JSubMenuHelper::addEntry(FactoryText::_('submenu_' . $item), $link, $item == $view);
    }
	}
}
