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

// Initialize Joomla framework.
define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);
define('JPATH_BASE', dirname(__FILE__).'/../..');

/* Required Files */
require_once JPATH_BASE.'/includes/defines.php';
require_once JPATH_BASE.'/includes/framework.php';

// Initilaise the application
$app = JFactory::getApplication('site');

JLoader::register('FactoryApplication', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_mediamallfactory'.DS.'libraries'.DS.'factory'.DS.'application.php');

// Run application.
$factoryApp = FactoryApplication::getInstance(array(
  'app'       => $app,
  'component' => 'MediaMallFactory',
  'option'    => 'com_mediamallfactory',
));

jimport('joomla.application.component.model');
JModel::addIncludePath(JPATH_SITE.DS.'components'.DS.'com_mediamallfactory'.DS.'models');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_mediamallfactory'.DS.'tables');

$model = JModel::getInstance('PurchaseCredits', 'MediaMallFactoryFrontendModel');
$model->notify();
