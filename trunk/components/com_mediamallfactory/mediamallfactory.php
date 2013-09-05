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

// Include dependencies.
$option = 'com_mediamallfactory';
JLoader::register('FactoryApplication', JPATH_ADMINISTRATOR.DS.'components'.DS.$option.DS.'libraries'.DS.'factory'.DS.'application.php');

// Run application.
$factoryApp = FactoryApplication::getInstance(array(
  'component' => 'MediaMallFactory',
  'option'    => $option,
));
$factoryApp->run();

//$factoryApp->createView('list');
//$factoryApp->createModel('categories');
//$factoryApp->createModel('categories');
//$factoryApp->createModelList('list');
