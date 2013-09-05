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

class MediaMallFactoryBackendViewUser extends FactoryView
{
  protected
    $buttons = array('apply', 'save', 'close'),
    $get = array('state', 'item', 'form', 'messages', 'messageForm', 'author', 'authorForm'),
    $css = array('edit', 'views/edit', 'admin/edit', 'buttons', 'admin/adminmessages'),
    $behaviors = array('tooltip', 'formvalidation'),
    $id = 'user_id',
    $title = 'username'
  ;
}
