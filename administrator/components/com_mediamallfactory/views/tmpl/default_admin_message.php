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

<div class="admin-message <?php echo $this->i % 2 ? '' : 'even'; ?> <?php echo $this->message->is_admin ? 'admin' : ''; ?>">
  <?php echo nl2br($this->message->message); ?>

  <div class="admin-message-info">
    <span class="factory-button-text button-<?php echo $this->message->user_id ? 'user' : 'application'; ?>"><?php echo $this->message->user_id ? $this->message->username : FactoryText::_('comment_system'); ?></span>
    <span class="factory-button-text button-clock"><?php echo JHtml::_('MediaMallFactory.date', $this->message->created_at); ?></span>
  </div>
</div>
