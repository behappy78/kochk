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

class MediaMallFactoryFrontendViewRegistration extends FactoryView
{
    protected
    $get = array('item', 'form', 'state'),
    $css = array('edit'),
    $js = array('edit'),
    $behaviors = array('formvalidation', 'tooltip'),
    $jtexts = array('JGLOBAL_VALIDATION_FORM_FAILED')
  	;
   /*function display($tpl = null)
    {
        $session =& JFactory::getSession();
	    $step = $session->get('step'); 
        //$step ++;
        if ($tpl == null)
            $tpl = $step;
        $tpl = $step;
        //$this->setLayout('buttons');
        parent::display();
        echo '</div>';
    } */ 	
}
