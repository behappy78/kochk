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

<div class="factory-view view-configuration">
  <div class="adminform">
    <div class="width-30 fltlft">
      <div class="cpanel">
        <?php foreach ($this->items as $item): ?>
          <?php if ('' == $item): ?>
            <div class="clr"></div>
          <?php else: ?>
            <?php echo JHtml::_('icons.button', $item); ?>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
