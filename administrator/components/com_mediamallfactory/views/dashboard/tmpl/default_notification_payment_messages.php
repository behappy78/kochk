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


<div class="stat-block" xmlns="http://www.w3.org/1999/html">
  <div class="count <?php echo $this->notifications['payment_messages'] ? 'unread' : ''; ?>">
    <a href="<?php echo FactoryRoute::view('requests&reset_filters=1&filter_messages=1'); ?>">
      <?php echo $this->notifications['payment_messages']; ?>
    </a>
  </div>

  <div class="text">
    <?php echo FactoryText::plural('dashboard_notification_payment_messages', $this->notifications['payment_messages']); ?>
  </div>
</div>
