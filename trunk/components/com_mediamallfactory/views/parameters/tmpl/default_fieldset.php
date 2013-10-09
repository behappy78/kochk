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
  <legend><?php echo FactoryText::_('form_profile_view_legend_'.$this->fieldset.'_label'); ?></legend>

  <?php echo $this->loadTemplate('form', array('form' => $this->form, 'fieldset' => $this->fieldset)); ?>

  <div class="buttons">
  	<a href="<?php echo FactoryRoute::view('editparameters'); ?>" class="factory-button-text button-user-edit"><?php echo FactoryText::_('profile_edit_parameters'); ?></a>
    <a href="<?php echo FactoryRoute::view('historypurchases'); ?>" class="factory-button-text button-history"><?php echo FactoryText::_('profile_purchases_history'); ?></a><?php echo JHtml::_('MediaMallFactoryParameters.unread', $this->unread, 'purchases'); ?>
    <a href="<?php echo FactoryRoute::view('invoices'); ?>" class="factory-button-text button-history"><?php echo FactoryText::_('profile_invoices'); ?></a>
    <a href="<?php echo FactoryRoute::view('contactsuser'); ?>" class="factory-button-text button-history"><?php echo FactoryText::_('profile_user_contacts'); ?></a><?php echo JHtml::_('MediaMallFactoryParameters.unread', $this->unread, 'contactsUser'); ?>
    <a href="<?php echo FactoryRoute::view('dashboard'); ?>" class="factory-button-text button-history"><?php echo FactoryText::_('profile_cancel'); ?></a>
  </div>
</fieldset>
