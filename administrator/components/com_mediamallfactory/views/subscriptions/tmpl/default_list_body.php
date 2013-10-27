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
    <?php echo JHtml::_('grid.id', $this->i, $this->item->id); ?>
  </td>

  <td>
    <a href="<?php echo FactoryRoute::view('subscription&id=' . $this->item->id); ?>"><?php echo $this->item->title; ?></a>
	</td>

  <td>
    <?php echo $this->item->amount.' '.'Crédits'; ?>
  </td>      
  <td>
    <?php echo $this->item->validity.' '.$this->item->validity_unit; ?>
  </td>      

  <td>
    <?php echo $this->item->country; ?>
  </td> 
  <td>
    <?php echo $this->item->countries; ?>
  </td>  

  <td class="center">
    <?php echo JHtml::_('jgrid.published', $this->item->published, $this->i, 'countries.'); ?>
  </td>
</tr>