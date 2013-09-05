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

JLoader::register('MediaMallFactoryFrontendViewAdminMessages', FactoryApplication::getInstance()->getPath('component_site').DS.'views'.DS.'adminmessages'.DS.'view.html.php');

class MediaMallFactoryFrontendViewMediaComments extends MediaMallFactoryFrontendViewAdminMessages
{
  public function __construct($config = array())
  {
    $config['get'] = array('media');

    parent::__construct($config);
  }
}
