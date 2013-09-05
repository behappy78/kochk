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

class MediaMallFactoryBackendViewInvoice extends FactoryView
{
  protected
    $get = array('template'),
    $html = array('admin'),
    $css = array('admin/views/invoice', 'buttons')
  ;

  public function display($tpl = null)
  {
    $document = JFactory::getDocument();
    $document->addStylesheet('components/com_mediamallfactory/assets/css/views/invoice.print.css', 'text/css', 'print');

    parent::display($tpl);
  }
}
