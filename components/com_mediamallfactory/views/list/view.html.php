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

class MediaMallFactoryFrontendViewList extends FactoryView
{
  protected
    $get = array('filters', 'items', 'pagination', 'state', 'thumbnailWidth'),
    $css = array('list', 'views/list', 'buttons'),
    $js = array('list'),
    $html = array('media'),
    $behaviors = array('tooltip', 'factoryDropDown')
  ;
}
