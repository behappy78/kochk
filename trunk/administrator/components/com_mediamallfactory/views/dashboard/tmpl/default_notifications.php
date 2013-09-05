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

<div class="box" id="portlet_notifications">
  <div class="header"><?php echo FactoryText::_('dashboard_box_notifications_header'); ?></div>
  <div class="content">
    <?php echo $this->loadTemplate('notification_pending_media'); ?>
    <?php echo $this->loadTemplate('notification_media_messages'); ?>
    <?php echo $this->loadTemplate('notification_payment_messages'); ?>
  </div>
</div>
