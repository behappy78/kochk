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

<div class="details">
  <div class="details-right" style="width: <?php echo $this->thumbnailWidth; ?>px;">
    <?php echo JHtml::_('MediaMallFactoryMedia.thumbnail', $this->item->getThumbnailSource($this->thumbnailWidth)); ?>
  </div>

  <div class="details-content">
    <div class="details-label"><?php echo FactoryText::_('media_details_rating'); ?></div>
    <div class="details-field"><?php echo JHtml::_('MediaMallFactoryMedia.rating', $this->item->rating, $this->item->votes, $this->item->id, true); ?></div>

    <div class="details-label"><?php echo FactoryText::_('media_details_type'); ?></div>
    <div class="details-field"><a href="<?php echo FactoryRoute::view('list&filter[type]=' . $this->type->id); ?>"><?php echo $this->type->title; ?></a></div>

    <div class="details-label"><?php echo FactoryText::_('media_details_category'); ?></div>
    <div class="details-field"><a href="<?php echo FactoryRoute::view('list&filter[category]=' . $this->item->category_id); ?>"><?php echo $this->category->title; ?></a></div>

    <div class="details-label"><?php echo FactoryText::_('media_details_author'); ?></div>
    <div class="details-field"><a href="<?php echo FactoryRoute::view('list&filter[user]=' . $this->authorUsername); ?>"><?php echo $this->authorUsername; ?></a></div>

    <div class="details-label"><?php echo FactoryText::_('media_details_created_at'); ?></div>
    <div class="details-field"><?php echo JHtml::_('MediaMallFactory.date', $this->item->created_at); ?></div>
  </div>

  <?php if ($this->item->description || $this->item->details_media || $this->item->details_archive): ?>
    <?php echo JHtml::_('tabs.start', 'media-info-'.$this->item->id, array('useCookie' => 1)); ?>

      <?php if ($this->item->description): ?>
        <?php echo JHtml::_('tabs.panel', 'Description', 'description'); ?>
          <?php echo JHtml::_('FactoryAdmin.nl2p', $this->item->description); ?>
      <?php endif; ?>


      <?php if ($this->item->details_media): ?>
        <?php echo JHtml::_('tabs.panel', 'Media Details', 'media-details'); ?>
          <?php echo JHtml::_('FactoryAdmin.nl2p', $this->item->details_media); ?>
      <?php endif; ?>

      <?php if ($this->item->details_archive): ?>
        <?php echo JHtml::_('tabs.panel', 'Archive Details', 'archive-details'); ?>
          <?php echo JHtml::_('FactoryAdmin.nl2p', $this->item->details_archive); ?>
      <?php endif; ?>

    <?php echo JHtml::_('tabs.end'); ?>
  <?php endif; ?>
</div>
