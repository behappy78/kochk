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

<h1><?php echo FactoryText::_('paypal_order_page_title'); ?></h1>
<p><?php echo FactoryText::sprintf('paypal_order_page_confirm_text', $this->getOrder('title'), $this->getOrder('full_amount')); ?></p>

<form action="<?php echo $this->getAction(); ?>" method="post">
  <input type="hidden" name="item_number"   value="<?php echo $this->getOrder('id'); ?>" />
  <input type="hidden" name="on0"           value="userid" />
  <input type="hidden" name="os0"           value="<?php echo $this->getOrder('user_id'); ?>" />
  <input type="hidden" name="amount"        value="<?php echo $this->getOrder('amount'); ?>" />
  <input type="hidden" name="currency_code" value="<?php echo $this->getOrder('currency'); ?>" />

  <input type="hidden" name="cmd"           value="_xclick" />
  <input type="hidden" name="business"      value="<?php echo $this->getParam('email'); ?>" />
  <input type="hidden" name="item_name"     value="<?php echo $this->getOrder('title'); ?>" />
  <input type="hidden" name="quantity"      value="1" />

  <input type="hidden" name="return"        value="<?php echo $this->getUrl('complete'); ?>" />
  <input type="hidden" name="cancel_return" value="<?php echo $this->getUrl('cancel'); ?>" />
  <input type="hidden" name="notify_url"    value="<?php echo $this->getUrl('notify'); ?>" />

  <input type="hidden" name="tax"           value="0" />
  <input type="hidden" name="no_note"       value="1" />
  <input type="hidden" name="no_shipping"   value="1" />

  <input type="image" src="<?php echo $this->getPurchaseLogo(); ?>" name="submit" />
</form>
