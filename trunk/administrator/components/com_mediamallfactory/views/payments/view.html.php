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

class MediaMallFactoryBackendViewPayments extends FactoryView
{
  protected
    $buttons = array(
      'edit',
      '',
      array('markcomplete', 'orders_mark_completed', 'publish', true),
      array('markfailed', 'orders_mark_failed', 'unpublish', true),
      '',
      'delete'),
    $get = array('state', 'items', 'pagination', 'filters'),
    $html = array('admin', 'orders'),
    $tpl = '/list'
  ;
}
