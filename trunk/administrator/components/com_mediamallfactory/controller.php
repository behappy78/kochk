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

jimport('joomla.application.component.controller');

class MediaMallFactoryBackendController extends JController
{
  protected $default_view = 'dashboard';

  public function display($cachable = false, $urlparams = false)
	{
    $view = JFactory::getApplication()->input->getCmd('view', $this->default_view);

    if ('categories' == $view) {
      //JFactory::getApplication()->redirect(JRoute::_('index.php?option=com_categories&extension=com_mediamallfactory', false));
    }
    if ('publishers' == $view) {
      JFactory::getApplication()->redirect(JRoute::_('index.php?option=com_mediamallfactory&view=categories&level=1', false));
    }
    JLoader::register('MediaMallFactoryHelper', FactoryApplication::getInstance()->getPath('component_administrator').DS.'helpers'.DS.'mediamallfactory.php');

    MediaMallFactoryHelper::addSubmenu($view);

		parent::display();

		return $this;
	}
}
