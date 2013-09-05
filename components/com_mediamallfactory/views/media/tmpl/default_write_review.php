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

<a name="write-review"></a>
<fieldset>
  <legend><?php echo FactoryText::_('media_fieldset_write_review'); ?></legend>

  <?php if ($this->item->isAllowedAddReview()): ?>
    <a href="#" class="factory-button-text button-ballon-plus show-review-form"><?php echo FactoryText::_('media_review_write_review_link'); ?></a>
    <div style="display: none;" class="comment-form">
      <?php $this->review->display(); ?>
    </div>
  <?php else: ?>
    <?php echo $this->item->getError(); ?>
  <?php endif; ?>
</fieldset>
