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

class MediaMallFactoryBackendViewCategories extends FactoryView
{
  protected
    $buttons = array('add'=>'category', 'edit'=>'category', '', 'delete', 'publish', 'unpublish'),
    $get = array('state', 'items', 'pagination', 'filters'),
    $tpl = '/list'
  ;
  function __construct($config)
  {
    $level   = JFactory::getApplication()->input->get->getInt('level', 0);
    $cats = array('category', 'publishers');
    $this->buttons = array('add'=>$cats[$level], 'edit'=>$cats[$level], '', 'delete', 'publish', 'unpublish');
    parent::__construct($config);
  }
}
