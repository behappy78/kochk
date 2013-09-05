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

JLoader::register('MediaMallFactoryFrontendModelAdminMessages', FactoryApplication::getInstance()->getPath('component_site').DS.'models'.DS.'adminmessages.php');

class MediaMallFactoryFrontendModelPaymentRequestComments extends MediaMallFactoryFrontendModelAdminMessages
{
  protected $request = null;

  public function getRequest()
  {
    if (is_null($this->request)) {
      $request_id = JFactory::getApplication()->input->get->getInt('request_id', 0);
      $user_id    = JFactory::getUser()->id;
      $table      = FactoryTable::getInstance('PaymentRequest');

      $table->load(array('id' => $request_id, 'user_id' => $user_id));

      if ($request_id != $table->id) {
        throw new Exception(FactoryText::sprintf('paymentrequestcomments_request_not_found', $request_id), 404);
        return false;
      }

      $this->request = $table;
    }

    return $this->request;
  }

  public function getItems()
  {
    return parent::getItems('payment_request', $this->getRequest()->id);
  }
}
