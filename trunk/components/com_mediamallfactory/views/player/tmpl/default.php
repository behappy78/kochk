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

<div class="factory-view view-player">
  <h1><?php echo $this->item->title; ?></h1>

  <?php echo $this->loadTemplate('buttons'); ?>

  <div class="mediamallfactory-player">
    <div class="top">
      <?php echo $this->player->render(); ?>
    </div>

    <div class="bottom">
      <div class="description"><?php echo $this->item->description ? $this->item->description : FactoryText::_('categories_no_description_available'); ?></div>
      <?php echo JHtml::_('MediaMallFactoryMedia.simpleRating', $this->item->rating); ?>
    </div>
  </div>

  <?php echo $this->loadTemplate('buttons'); ?>
</div>
