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

<?php if ($this->messages): ?>
  <?php echo JHtml::_('sliders.panel', FactoryText::_('item_authro_slider_title'), 'author'); ?>
    <div class="write-message">
      <table>
        <?php foreach ($this->authorForm->getFieldset('author') as $field): ?>
          <tr>
            <th><?php echo $field->label; ?></th>
            <td><?php echo JHtml::_('Factory.field', $field, $this->authorForm); ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
<?php endif; ?>
