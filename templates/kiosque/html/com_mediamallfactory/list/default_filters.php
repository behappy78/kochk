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

<div class="left"> 
	<span class="s-title"><?php echo FactoryText::_('list_filter_label'); ?>:</span>
	<span class="list-nav">
		<?php echo JHtml::_('Factory.listFilter', 'cost', $this->filters); ?>
		<?php echo JHtml::_('Factory.listFilter', 'category', $this->filters); ?> 
		<?php echo JHtml::_('Factory.listFilter', 'type', $this->filters); ?> 
		<?php echo JHtml::_('Factory.listFilter', 'archive', $this->filters); ?> 
		</span>

</div>
<div class="right"> 
	<span><?php echo FactoryText::_('list_sort_label'); ?>:</span>
    <span>
  <?php echo JHtml::_('Factory.listFilter', 'sort', $this->filters); ?> 
  <?php echo JHtml::_('Factory.listFilter', 'dir', $this->filters); ?>
  	</span> 
</div>
