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

abstract class MediaMallFactoryFrontendViewAdminMessages extends FactoryView
{
  protected
    $get = array('items', 'form'),
    $css = array('edit', 'buttons', 'views/adminmessages'),
    $js = array('edit'),
    $behaviors = array('formvalidation', 'tooltip'),
    $jtexts = array('JGLOBAL_VALIDATION_FORM_FAILED')
  ;

  public function __construct($config = array())
  {
    parent::__construct($config);

    $array = array('get', 'css', 'js', 'behaviors', 'jtexts');
    foreach ($array as $item) {
      if (isset($config[$item])) {
        $this->$item = array_merge($this->$item, $config[$item]);
      }
    }
  }
}
