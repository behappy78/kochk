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

<tr class="row<?php echo $this->i % 2; ?>">
  <td class="center">
    <?php echo JHtml::_('grid.id', $this->i, $this->item->user_id); ?>
  </td>

  <td>
    <a href="<?php echo FactoryRoute::view('user&id=' . $this->item->user_id); ?>"><?php echo $this->item->username; ?></a>
	</td>

  <td class="center">
    <?php echo $this->item->credits; ?>
  </td>

  <td class="right">
    <?php echo $this->item->balance; ?>
  </td>

  <td class="right">
    <?php echo $this->item->revenue ? $this->item->revenue : '-'; ?>
  </td>

  <td class="center">
    <?php if ($this->item->media): ?>
      <a href="<?php echo FactoryRoute::view('list&filter_search='.urlencode('user: ' . $this->item->username)); ?>"><?php echo $this->item->media; ?></a>
    <?php else: ?>
      <?php echo $this->item->media; ?>
    <?php endif; ?>
  </td>
</tr>
