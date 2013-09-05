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
  <div class="interact-header"><?php echo FactoryText::_('media_download_media_header'); ?></div>
  <div class="interact-icon download-media-icon"></div>

  <?php if ($this->item->isOwner() || !$this->item->cost_archive || isset($this->purchases['archive'])): ?>
    <a href="<?php echo FactoryRoute::task('media.download&media_id=' . $this->item->id.'&type=archive'); ?>"><?php echo FactoryText::_('media_download_media_link'); ?></a>
  <?php else: ?>
    <a href="<?php echo FactoryRoute::task('media.purchase&type=archive&media_id=' . $this->item->id); ?>"><?php echo FactoryText::_('media_download_purchase_link'); ?></a>
  <?php endif; ?>

  <div class="interact-info">
    <?php if ($this->item->isOwner()): ?>
      <?php echo FactoryText::_('media_download_media_author'); ?>
    <?php elseif (!$this->item->cost_archive): ?>
      <?php echo FactoryText::_('media_download_free_media'); ?>
    <?php elseif (isset($this->purchases['archive'])): ?>
      <?php echo FactoryText::plural('media_download_downloads_remaining', $this->purchases['archive']->getViewsRemaining()); ?>
    <?php else: ?>
      <?php echo FactoryText::plural('media_view_credits', $this->item->cost_archive); ?>
    <?php endif; ?>
  </div>
</div>
