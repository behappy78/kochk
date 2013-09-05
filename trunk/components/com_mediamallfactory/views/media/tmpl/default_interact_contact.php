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

<?php if (!$this->item->isOwner() && $this->item->isAllowedContact()): ?>
  <div class="interact-container">
    <div class="interact-header"><?php echo FactoryText::_('media_contact_author_header'); ?></div>
    <div class="interact-icon contact-author-icon"></div>

    <?php if (isset($this->purchases['contact'])): ?>
      <a href="<?php echo FactoryRoute::view('contacts&contact_id=' . $this->purchases['contact']->id); ?>"><?php echo FactoryText::_('media_contact_author'); ?></a>
    <?php else: ?>
      <a href="<?php echo FactoryRoute::task('media.purchase&type=contact&media_id=' . $this->item->id); ?>"><?php echo FactoryText::_('media_purchase_author_contact'); ?></a>
    <?php endif; ?>

    <div class="interact-info">
      <?php if (isset($this->purchases['contact'])): ?>
        <?php echo FactoryText::plural('media_author_contact_remaining', 0); ?>
      <?php else: ?>
        <?php echo FactoryText::plural('media_view_credits', FactoryApplication::getInstance()->getParam('general.credits.contact_cost', 1)); ?>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>
