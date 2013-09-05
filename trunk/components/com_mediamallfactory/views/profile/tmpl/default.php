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

<div class="factory-view view-profile factory-view-form">
  <h1><?php echo FactoryText::_('profile_page_title'); ?></h1>

  <fieldset>
    <legend><?php echo FactoryText::_('profile_fieldset_user_credits_label'); ?></legend>
    <?php echo FactoryText::plural('profile_user_credits_current', '<span class="factory-button-text button-credits"><b>'.$this->item->credits.'</b></span>'); ?>

    <div class="buttons">
      <a href="<?php echo FactoryRoute::view('purchasecredits'); ?>" class="factory-button-text button-forward-medium"><?php echo FactoryText::_('profile_purchase_credits'); ?></a>
      <a href="<?php echo FactoryRoute::view('historycredits'); ?>" class="factory-button-text button-history"><?php echo FactoryText::_('profile_credits_history'); ?></a><?php echo JHtml::_('MediaMallFactoryProfile.unread', $this->unread, 'credits_log'); ?>
    </div>
  </fieldset>

  <?php echo $this->loadTemplate('fieldset', array('fieldset' => 'user')); ?>

  <?php if ($this->isAuthor): ?>
    <?php echo $this->loadTemplate('author'); ?>
  <?php endif; ?>
</div>
