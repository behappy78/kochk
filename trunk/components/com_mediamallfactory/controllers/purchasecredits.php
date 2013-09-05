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

class MediaMallFactoryFrontendControllerPurchaseCredits extends JController
{
  public function purchase()
  {
    //JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

    $app = JFactory::getApplication();
    $data = $app->input->get('purchasecredits', array(), 'array');
    $model = $this->getModel('PurchaseCredits');

    // Get payment gateway.
    $gateway = $model->getGateway($data['method']);
    if (!$gateway) {
      throw new Exception(FactoryText::_('purchasecredits_error_gateway_not_found'), 404);
    }

    FactoryHtml::stylesheet('views/purchasecredits');

    // Execute payment gateway step.
    $step = isset($data['step']) ? $data['step'] : 1;
    $gateway->execute($step, $data);
  }

  public function cancel()
  {
    $this->setRedirect(FactoryRoute::view('profile'));
  }

  public function authorise($task)
  {
    if (!parent::authorise($task)) {
      return false;
    }

    $permissions = array(
      'purchase' => array('logged'),
      'cancel'   => array('logged'),
    );

    if (!isset($permissions[$task])) {
      return true;
    }

    foreach ($permissions[$task] as $permission) {
      FactoryApplication::getInstance()->checkPermission($permission);
    }

    return true;
  }
}
