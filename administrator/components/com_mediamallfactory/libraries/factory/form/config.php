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

<?php echo JHtml::_('tabs.start', 'config', array('useCookie' => 1)); ?>
  <?php foreach ($this->getConfigTabs() as $tab => $sides): ?>
    <?php echo JHtml::_('tabs.panel', FactoryText::_('settings_tab_' . $tab), $tab); ?>

      <?php foreach ($sides as $side => $fields): ?>
        <div class="width-<?php echo 'full' == $side ? 100 : 50; ?> <?php echo 'left' == $side ? 'fltlft' : 'fltrt'; ?>">

          <?php foreach ($fields as $element): ?>
            <fieldset class="adminform">
              <legend><?php echo FactoryText::_('settings_fieldset_' . $element); ?></legend>

              <table>
                <?php foreach($this->getConfigFields($tab, $element) as $field): ?>
                  <tr>
                    <?php if ('' != $field->label): ?>
                      <th><?php echo $field->label; ?></th>
                    <?php endif; ?>

                    <td><?php echo $field->input; ?></td>
                  </tr>
                <?php endforeach; ?>
              </table>
            </fieldset>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>

      <div class="clr"></div>
  <?php endforeach; ?>
<?php echo JHtml::_('tabs.end'); ?>

<?php echo $this->renderHiddenFields(); ?>
