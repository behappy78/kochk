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
  <legend><?php echo FactoryText::_('form_'.$this->form->getName().'_legend_'.$this->fieldset.'_label'); ?></legend>

  <table width="100%">
    <?php foreach ($this->form->getFieldset($this->fieldset) as $field): ?>
      <tr>
        <th><?php echo $field->label; ?></th>
        <td><?php echo $field->input; ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</fieldset>
