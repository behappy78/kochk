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

class MediaMallFactoryBackendControllerInvoices extends JController
{
  public function delete()
  {
    $app   = JFactory::getApplication();
    $batch = $app->input->post->get('cid', array(), 'array');
    $model = $this->getModel('Invoice');

    if ($model->delete($batch)) {
      $msg = FactoryText::plural('list_delete_success', count($batch));
    } else {
      $msg = FactoryText::_('list_delete_error');

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'error');
      }
    }

    $this->setRedirect(FactoryRoute::view('invoices'), $msg);
  }
}
