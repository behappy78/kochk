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

<fieldset class="adminform">
  <legend><?php echo FactoryText::_('settings_fieldset_' . $this->group); ?></legend>

  <ul class="adminformlist">
    <?php foreach ($this->form->getFieldset($this->tab) as $field): ?>

      <?php if ($field->group == $this->tab.'.'.$this->group): ?>
        <li>
          <?php if ('true' != $this->form->getFieldAttribute($field->fieldname, 'nolabel', 'false', $field->group)): ?>
            <?php echo $field->label; ?>
          <?php endif; ?>

          <?php echo $field->input; ?>
        </li>
      <?php endif; ?>

    <?php endforeach; ?>
  </ul>
</fieldset>
