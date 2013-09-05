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

    <div class="width-40 fltlft">
      <fieldset>
        <legend><?php echo FactoryText::_('configuration_fieldset_version'); ?></legend>
        <table>
          <tr>
            <th><?php echo FactoryText::_('configuration_current_version'); ?></th>
            <td><?php echo $this->version; ?></td>
          </tr>

          <tr class="even">
            <th><?php echo FactoryText::_('configuration_current_gateways'); ?></th>
            <td><?php echo $this->gateways ? implode('<br />', $this->gateways) : '-'; ?></td>
          </tr>
        </table>
      </fieldset>
    </div>
  </div>
</div>
