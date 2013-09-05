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

<div class="interact-container">
  <div class="interact-header"><?php echo FactoryText::_('media_view_media_header'); ?></div>
  <div class="interact-icon view-media-icon"></div>

  <?php if ($this->item->isOwner() || !$this->item->cost_media || isset($this->purchases['media'])): ?>
    <a href="<?php echo FactoryRoute::view('player&media_id=' . $this->item->id); ?>"><?php echo FactoryText::_('media_view_media_link'); ?></a>
  <?php else: ?>
    <a href="<?php echo FactoryRoute::task('media.purchase&type=media&media_id=' . $this->item->id); ?>"><?php echo FactoryText::plural('media_purchase_media_link', $this->type->getViews()); ?></a>
  <?php endif; ?>

  <div class="interact-info">
    <?php if ($this->item->isOwner()): ?>
      <?php echo FactoryText::_('media_view_media_author'); ?>
    <?php elseif (!$this->item->cost_media): ?>
      <?php echo FactoryText::_('media_view_free_media'); ?>
    <?php elseif (isset($this->purchases['media'])): ?>
      <?php echo FactoryText::plural('media_view_views_remaining', $this->purchases['media']->getViewsRemaining()); ?>
    <?php else: ?>
      <?php echo FactoryText::plural('media_view_credits', $this->item->cost_media); ?>
    <?php endif; ?>
  </div>
</div>
