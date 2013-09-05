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

class MediaMallFactoryFrontendViewMediaStats extends FactoryView
{
  protected
    $get = array('filters', 'items', 'pagination', 'editOwnMedia'),
    $html = array('media'),
    $css = array('list', 'buttons'),
    $js = array('list'),
    $jtexts = array('COM_MEDIAMALLFACTORY_LIST_BATCH_SELECT_ITEM'),
    $behaviors = array('factoryDropDown', 'tooltip')
  ;
}
