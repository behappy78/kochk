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

<tr class="<?php echo $this->i % 2 ? '' : 'even'; ?>">
  <td>
    <a href="#" onclick="window.open('<?php echo FactoryRoute::view('invoice&invoice_id='.$this->item->id.'&tmpl=component'); ?>', 'mediamallfactoryinvoice', 'width=800, height=600'); return false;">
      <?php echo $this->item->title; ?>
    </a>
  </td>

  <td class="right">
    <?php echo JHtml::_('Factory.currency', $this->item->amount, $this->item->currency); ?>
  </td>

  <td>
    <?php echo JHtml::_('MediaMallFactory.date', $this->item->created_at); ?>
  </td>
</tr>
