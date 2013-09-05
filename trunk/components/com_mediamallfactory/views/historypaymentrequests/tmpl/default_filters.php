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

<div class="filters">
  <label><?php echo FactoryText::_('list_filter_label'); ?>:</label>
  <?php echo JHtml::_('Factory.listFilter', 'status', $this->filters); ?>

  <label><?php echo FactoryText::_('list_sort_label'); ?>:</label>
  <?php echo JHtml::_('Factory.listFilter', 'sort', $this->filters); ?>
  <?php echo JHtml::_('Factory.listFilter', 'dir', $this->filters); ?>
</div>
