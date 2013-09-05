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

<div class="factory-view view-categories">
  <?php if ('root' == $this->item->id): ?>
    <h1><?php echo FactoryText::_('categories_root_title'); ?></h1>
    <p><?php echo FactoryText::_('categories_root_description'); ?></p>
  <?php else: ?>
    <h1><?php echo $this->item->title; ?></h1>
    <div class="category">
      <div style="width: <?php echo $this->thumbnailWidth; ?>px;" class="photo <?php echo '' == $this->item->params->get('thumbnail.current') ? 'no-photo' : ''; ?>">
        <?php if ('' != $this->item->params->get('thumbnail.current')): ?>
          <img src="<?php echo $this->item->params->get('thumbnail.current'); ?>" />
        <?php endif; ?>
      </div>

      <div class="details">
        <p><?php echo $this->item->description ? $this->item->description : FactoryText::_('categories_no_description_available'); ?></p>
        <?php echo JHtml::_('MediaMallFactoryMedia.mediaCountLink', $this->item->id, $this->item->params->get('media_files')); ?>
        <?php echo JHtml::_('MediaMallFactoryMedia.categoryPurchaseLink', $this->item->id, $this->item->params->get('purchase_cost', 0)); ?>
      </div>
    </div>
  <?php endif; ?>

  <?php if ('root' == $this->item->id): ?>
    <div style="margin-top: 30px;"></div>
  <?php elseif ($this->items): ?>
    <h1><?php echo FactoryText::_('categories_subcategories'); ?></h1>
  <?php endif; ?>

  <?php foreach ($this->items as $this->item): ?>
    <div class="category">
      <div style="width: <?php echo $this->thumbnailWidth; ?>px;" class="photo <?php echo '' == $this->item->params->get('thumbnail.current') ? 'no-photo' : ''; ?>">
        <?php if ('' != $this->item->params->get('thumbnail.current')): ?>
          <img src="<?php echo $this->item->params->get('thumbnail.current'); ?>" />
        <?php endif; ?>
      </div>

      <div class="details">
        <big><?php echo JHtml::_('Factory.link', 'categories&category_id=' . $this->item->id, $this->item->title); ?></big>
        <?php echo JHtml::_('MediaMallFactoryMedia.mediaCountLink', $this->item->id, $this->item->params->get('media_files')); ?>
        <p><?php echo $this->item->description ? JHtml::_('Factory.stripText', $this->item->description, 220) : FactoryText::_('categories_no_description_available'); ?></p>
        <?php echo JHtml::_('MediaMallFactoryCategories.subcategories', $this->item); ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>
