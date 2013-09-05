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

<div class="factory-view view-comments factory-view-list">
  <?php echo JHtml::_('Factory.beginForm', FactoryRoute::view('media&media_id=' . $this->media . '#reviews')); ?>

    <?php echo $this->loadTemplate('filters'); ?>

    <div class="view-comments-list">
      <?php if ($this->items): ?>
        <?php foreach ($this->items as $this->i => $this->item): ?>
          <?php echo $this->loadTemplate('item'); ?>
        <?php endforeach; ?>
      <?php else: ?>
        <p><?php echo FactoryText::_('comments_no_results_found'); ?></p>
      <?php endif; ?>
    </div>

    <?php echo $this->loadTemplate('pagination'); ?>
  </form>
</div>
