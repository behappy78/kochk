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

<?php JHtml::_('behavior.tooltip'); ?>
<?php JHtml::_('behavior.formvalidation'); ?>

<div class="factory-view-edit">
  <h1><?php echo FactoryText::_('sagepay_confirm'); ?></h1>

  <form action="<?php echo $this->getAction(); ?>" method="POST" id="SagePayForm" name="SagePayForm">
    <table>
      <?php $i = 0; foreach ($this->form->getFieldset('details') as $field): $i++ ; ?>
        <?php if (!$field->hidden): ?>
          <tr class="<?php echo $i % 2 ? '' : 'even'; ?>">
            <th><span class="hasTip" title="<?php echo $field->title; ?>::<?php echo $field->description; ?>"><?php echo $field->title; ?></span></th>
            <td><?php echo JHtml::_('Factory.field', $field, $this->form); ?></td>
          </tr>
        <?php endif; ?>
      <?php endforeach; ?>
    </table>

    <?php foreach ($this->form->getFieldset('hidden') as $field): ; ?>
      <?php echo $field->input; ?>
    <?php endforeach; ?>

    <input type="submit" value="<?php echo FactoryText::_('sagepay_continue'); ?>" />
  </form>
</div>
