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

class JFormFieldMediaMallFactoryMenuListRequest extends JFormFieldList
{
  protected $type = 'MediaMallFactoryMenuListRequest';

  protected function getOptions()
  {
    JLoader::register('FactoryApplication', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_mediamallfactory'.DS.'libraries'.DS.'factory'.DS.'application.php');
    $app = FactoryApplication::getInstance(array('option' => 'com_mediamallfactory'));
    $app->loadLanguage('site');
    JModel::addIncludePath(JPATH_SITE.DS.'components'.DS.'com_mediamallfactory'.DS.'models', 'MediaMallFactoryFrontendModel');
    $model = JModel::getInstance('List', 'MediaMallFactoryFrontendModel');

    $filters = $model->getFilters();

    return $filters[(string)$this->element['name']];
  }
}
