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

defined('_JEXEC') or die; ?>

<h1><?php echo FactoryText::_('moneybookers_order_page_title'); ?></h1>
<p><?php echo FactoryText::sprintf('moneybookers_order_page_confirm_text', $this->getOrder('title'), $this->getOrder('full_amount')); ?></p>

<form action="<?php echo $this->getParam('action'); ?>" method="post">
  <input type="hidden" name="pay_to_email"    value="<?php echo $this->getParam('email'); ?>" />
  <input type="hidden" name="hide_login"      value="0" />
  <input type="hidden" name="merchant_fields" value="m_userid,m_itemnr" />
  <input type="hidden" name="m_userid"        value="<?php echo $this->getOrder('user_id'); ?>" />
  <input type="hidden" name="m_itemnr"        value="<?php echo $this->getOrder('id'); ?>" />
  <input type="hidden" name="language"        value="EN" />

  <input type="hidden" name="return_url" value="<?php echo $this->getUrl('complete') ?>" />
  <input type="hidden" name="cancel_url" value="<?php echo $this->getUrl('cancel'); ?>" />
  <input type="hidden" name="status_url" value="<?php echo $this->getUrl('notify'); ?>" />

  <input type="hidden" name="amount"              value="<?php echo $this->getOrder('amount'); ?>" />
  <input type="hidden" name="currency"            value="<?php echo $this->getOrder('currency'); ?>" />
  <input type="hidden" name="detail1_description" value="<?php echo FactoryText::_('moneybookers_order_credits'); ?>" />
  <input type="hidden" name="detail1_text"        value="<?php echo $this->getOrder('title'); ?>" />

  <input type="image" src="<?php echo $this->getPurchaseLogo(); ?>" name="submit" />

</form>
