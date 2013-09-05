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

<?php if ($this->messages): ?>
  <?php echo JHtml::_('sliders.panel', FactoryText::_('media_messages_slider_title'), 'messages'); ?>

    <div class="messages">
      <div class="messages-list">
        <?php foreach ($this->messages as $this->i => $this->message): ?>
          <?php echo $this->loadTemplate('/admin_message'); ?>
        <?php endforeach; ?>
      </div>
    </div>
<?php endif; ?>
