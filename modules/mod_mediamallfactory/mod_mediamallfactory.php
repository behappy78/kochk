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
require_once dirname(__FILE__).DS.'helper.php';

// Initialise variables.
$option = 'com_mediamallfactory';

// Check if component is installed.
if (!modMediaMallHelper::isComponentInstalled($option)) {
  return false;
}

JLoader::register('FactoryApplication',         JPATH_ADMINISTRATOR.DS.'components'.DS.$option.DS.'libraries'.DS.'factory'.DS.'application.php');
JLoader::register('JHtmlMediaMallFactoryMedia', JPATH_SITE.DS.'components'.DS.$option.DS.'html'.DS.'media.php');

// Get application.
$factoryApp = FactoryApplication::getInstance(array(
  'component' => 'MediaMallFactory',
  'option'    => 'com_mediamallfactory',
));

$factoryApp->loadLanguage('site');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$list            = modMediaMallHelper::getList($params);

FactoryHtml::stylesheet('mod_mediamallfactory');

require JModuleHelper::getLayoutPath('mod_mediamallfactory', $params->get('layout', 'default'));
