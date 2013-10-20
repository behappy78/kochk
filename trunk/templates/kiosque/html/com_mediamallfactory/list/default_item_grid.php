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

<!--<div class="view-grid-media">
  <div class="media-left">-->
    <?php //echo JHtml::_('MediaMallFactoryMedia.thumbnail', $this->item->thumbnail); ?>
    <?php //echo JHtml::_('MediaMallFactoryMedia.archiveIcon', $this->item->has_archive); ?>
  <!--</div>
</div>
-->
<section class="grid-holder features-mags <?php echo $this->i % 2 ? '' : 'even'; ?>">






<div class="view-list-media <?php echo $this->i % 4 ? '' : $this->i; ?>">
  <div class="media-left" style="width: <?php echo $this->thumbnailWidth; ?>px;">
    <?php echo JHtml::_('MediaMallFactoryMedia.thumbnail', $this->item->thumbnail); ?>
    <?php echo JHtml::_('MediaMallFactoryMedia.archiveIcon', $this->item->has_archive); ?>
  </div>

  <div class="media-right">
    <?php echo JHtml::_('MediaMallFactoryMedia.price', $this->item->has_media, $this->item->has_archive, $this->item->cost_media, $this->item->cost_archive); ?>
  </div>

  <div class="media-content">
    <div class="media-title">
      <?php echo JHtml::_('Factory.link', 'media&media_id=' . $this->item->id, $this->item->title); ?>
      <?php if ($this->item->is_owner): ?>
        <?php echo JHtml::_('Factory.link', 'edit&media_id='.$this->item->id, '', 'view', 'class="factory-button button-document-pencil"'); ?>
      <?php endif; ?>
    </div>
    <p class="media-description"><?php echo $this->item->description ? JHtml::_('Factory.stripText', $this->item->description, 120) : FactoryText::_('categories_no_description_available'); ?></p>

    <?php echo JHtml::_('MediaMallFactoryMedia.rating', $this->item->rating, $this->item->votes, $this->item->id); ?>

    <p>
      <a href="<?php echo FactoryRoute::view('list&filter[user]=' . $this->item->username); ?>"><?php echo $this->item->username; ?></a> /
      <a href="<?php echo FactoryRoute::view('list&filter[type]=' . $this->item->type_id); ?>"><?php echo $this->item->type_title; ?></a> /
      <a href="<?php echo FactoryRoute::view('list&filter[category]=' . $this->item->category_id); ?>"><?php echo $this->item->category_title; ?></a> /
      <?php echo JHtml::_('MediaMallFactory.date', $this->item->created_at); ?>
    </p>
  </div>

</div>
