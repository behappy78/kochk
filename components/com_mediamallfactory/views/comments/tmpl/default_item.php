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

<div class="view-comments-comment <?php echo $this->i % 2 ? '' : 'even'; ?>" id="comment-<?php echo $this->item->id; ?>">
  <div class="comment-title">
    <?php echo $this->item->title; ?>&nbsp;
    <?php echo JHtml::_('MediaMallFactoryMedia.simpleRating', $this->item->rating); ?>
  </div>

  <p class="comment-message"><?php echo nl2br($this->item->message); ?></p>

  <div class="comment-details">
    <span class="factory-button-text button-user"><?php echo $this->item->username; ?></span>
    <span class="factory-button-text button-clock"><?php echo JHtml::_('MediaMallFactory.date', $this->item->created_at); ?></span>

    <div class="comment-help">
      <span class="label-help" style="display: none;"><?php echo FactoryText::_('comments_label_help'); ?></span>
      <a href="#" class="factory-button-text button-thumb-up help-button"><?php echo $this->item->votes_up; ?></a>
      <a href="#" class="factory-button-text button-thumb help-button"><?php echo $this->item->votes_down; ?></a>
    </div>
  </div>
</div>
