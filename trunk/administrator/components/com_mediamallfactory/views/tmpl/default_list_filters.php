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

<fieldset id="filter-bar">

  <?php if ($this->filters): ?>
    <?php if (in_array('search', $this->filters)): ?>
      <div class="filter-search fltlft">
        <?php echo $this->loadTemplate('list_filter_search'); ?>
	    </div>
    <?php endif; ?>

	  <div class="filter-select fltrt">
      <?php foreach ($this->filters as $this->filter): ?>
        <?php if ('search' != $this->filter): ?>
          <?php if (!in_array($this->filter, array('published'))): ?>
            <?php echo $this->loadTemplate('list_filter_generic'); ?>
          <?php else: ?>
            <?php echo $this->loadTemplate('list_filter_'.$this->filter); ?>
          <?php endif; ?>
        <?php endif; ?>
      <?php endforeach; ?>
	  </div>
  <?php endif; ?>

</fieldset>

<div class="clr"> </div>
