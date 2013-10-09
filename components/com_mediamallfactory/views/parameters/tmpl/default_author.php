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

<fieldset>
  <legend><?php echo FactoryText::_('profile_fieldset_author_balance_label'); ?></legend>
  <?php echo FactoryText::sprintf('profile_account_balance_current', JHtml::_('Factory.currency', $this->item->getBalanceAvailable())); ?>

  <div class="buttons">
    <a href="<?php echo FactoryRoute::view('withdrawfunds'); ?>" class="factory-button-text button-money-arrow"><?php echo FactoryText::_('profile_withdraw_funds'); ?></a>
    <a href="<?php echo FactoryRoute::view('convertfunds'); ?>" class="factory-button-text button-money-coin"><?php echo FactoryText::_('profile_convert_funds'); ?></a>
    <a href="<?php echo FactoryRoute::view('historybalance'); ?>" class="factory-button-text button-history"><?php echo FactoryText::_('profile_balance_history'); ?></a><?php echo JHtml::_('MediaMallFactoryProfile.unread', $this->unread, 'balance_log'); ?>
    <a href="<?php echo FactoryRoute::view('historysales'); ?>" class="factory-button-text button-history"><?php echo FactoryText::_('profile_sales_history'); ?> </a><?php echo JHtml::_('MediaMallFactoryProfile.unread', $this->unread, 'sales'); ?>
    <a href="<?php echo FactoryRoute::view('historypaymentrequests'); ?>" class="factory-button-text button-history"><?php echo FactoryText::_('profile_payment_requests_history'); ?></a><?php echo JHtml::_('MediaMallFactoryProfile.unread', $this->unread, 'admin_messages_payment_request'); ?>
  </div>
</fieldset>

<fieldset>
  <legend><?php echo FactoryText::_('form_profile_view_legend_author_label'); ?></legend>

  <?php echo $this->loadTemplate('form', array('form' => $this->form, 'fieldset' => 'author')); ?>

  <div class="buttons">
    <a href="<?php echo FactoryRoute::view('editprofile'); ?>" class="factory-button-text button-user-edit"><?php echo FactoryText::_('profile_edit_profile'); ?></a>
    <a href="<?php echo FactoryRoute::view('mediastats'); ?>" class="factory-button-text button-forward-medium"><?php echo FactoryText::_('profile_media_stats'); ?></a><?php echo JHtml::_('MediaMallFactoryProfile.unread', $this->unread, 'admin_messages_media'); ?>
    <a href="<?php echo FactoryRoute::view('contactsauthor'); ?>" class="factory-button-text button-history"><?php echo FactoryText::_('profile_contacts_author'); ?></a><?php echo JHtml::_('MediaMallFactoryProfile.unread', $this->unread, 'contactsAuthor'); ?>
  </div>
</fieldset>
