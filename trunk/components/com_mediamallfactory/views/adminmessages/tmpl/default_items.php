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

<fieldset>
  <legend><?php echo $this->legend; ?></legend>
  <?php if ($this->items): ?>
    <?php foreach ($this->items as $this->i => $this->item): ?>
      <?php echo $this->loadTemplate('item'); ?>
    <?php endforeach; ?>
  <?php else: ?>
    <p><?php echo FactoryText::_('adminmessages_no_results_found'); ?></p>
  <?php endif; ?>
</fieldset>
