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

<table>
  <?php $this->i = 0; foreach ($this->form->getFieldset($this->fieldset) as $field): $this->i++; ?>
    <tr class="<?php echo $this->i % 2 ? '' : 'even'; ?>">
      <th><span class="hasTip" title="<?php echo $field->title; ?>::<?php echo $field->description; ?>"><?php echo $field->title; ?></span></th>
      <td><?php echo JHtml::_('Factory.field', $field, $this->form); ?></td>
    </tr>
  <?php endforeach; ?>
</table>
