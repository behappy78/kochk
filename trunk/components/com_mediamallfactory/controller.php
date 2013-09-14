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

class MediaMallFactoryFrontendController extends JController
{
  protected $default_view = 'list';
  function __construct($config)
  {
        $jinput = JFactory::getApplication()->input;
        $session =& JFactory::getSession();
        $format = $jinput->get->get('format', 'html');
        if ($format == 'html' && $session->has('step'))
            $session->clear('step');
        parent::__construct($config);   
  }
  
}
