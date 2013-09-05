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
  <?php foreach ($this->getFieldset($this->fieldset) as $field): ?>
    <?php if (!$field->hidden): ?>
      <tr>
        <th><?php echo $field->label; ?></th>
        <td><?php echo $field->input; ?></td>
      </tr>
    <?php endif; ?>
  <?php endforeach; ?>
</table>
