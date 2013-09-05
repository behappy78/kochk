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

<div class="factory-view view-withdrawfunds factory-view-edit">
  <h1><?php echo FactoryText::_('withdrawfunds_page_title'); ?></h1>

  <?php if ($this->amountMin > $this->amountCurrent): ?>
    <?php echo FactoryText::sprintf('withdrawfunds_min_limit_error', $this->amountCurrent, $this->amountMin); ?>
  <?php else: ?>
    <p><?php echo FactoryText::sprintf('withdrawfunds_limit_info', $this->amountMin, $this->amountCurrent); ?></p>

    <?php if ($this->request): ?>
      <p><?php echo FactoryText::_('withdrawfunds_error_pending_request'); ?></p>
      <p>
        <a href="<?php echo FactoryRoute::view('profile'); ?>" class="factory-button-text button-back-medium"><?php echo FactoryText::_('withdrawfunds_back_to_profile'); ?></a>
        <a href="<?php echo FactoryRoute::view('historypaymentrequests'); ?>" class="factory-button-text button-history"><?php echo FactoryText::_('profile_payment_requests_history'); ?></a>
      </p>
    <?php else: ?>
      <?php echo $this->loadTemplate('form'); ?>
    <?php endif; ?>
  <?php endif; ?>
</div>
