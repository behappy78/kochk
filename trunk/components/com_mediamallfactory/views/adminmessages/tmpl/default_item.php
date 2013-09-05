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

<div class="message <?php echo $this->i % 2 ? '' : 'even'; ?> <?php echo $this->item->is_admin ? 'admin' : ''; ?>">
  <?php echo nl2br($this->item->message); ?>

  <div class="message-info">
    <span class="factory-button-text button-<?php echo $this->item->user_id ? 'user' : 'application'; ?>"><?php echo $this->item->user_id ? $this->item->username : FactoryText::_('comment_system'); ?></span>
    <span class="factory-button-text button-clock"><?php echo JHtml::_('MediaMallFactory.date', $this->item->created_at); ?></span>
  </div>
</div>
