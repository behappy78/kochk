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

defined('_JEXEC') or die; 
$types= array('Green', 'Silver', 'Gold');

$path = JRoute::_(JURI::root().'components/com_mediamallfactory/assets/images/packs_icons/'.$types[$this->item->type].'_'.$this->item->credits.'.png');
?>

<tr class="row<?php echo $this->i % 2; ?>">
  <td class="center">
    <?php echo JHtml::_('grid.id', $this->i, $this->item->id); ?>
  </td>
  <td>
    <a href="<?php echo FactoryRoute::view('category&id=' . $this->item->id); ?>"><?php echo '<img height="50px" src="'.$path. '" alt="-" />'; ?></a>
	</td>
  <td>
    <a href="<?php echo FactoryRoute::view('pack&id=' . $this->item->id); ?>"><?php echo $this->item->title; ?></a>
	</td>
  <td class="center">
    <?php echo $this->item->countryf; ?>
  </td>
  <td class="center">
    <?php echo $this->item->cgroup; ?>
  </td>  
  <td class="center">
    <?php echo $this->item->currc; ?>
  </td>

  <td>
    <?php echo $this->item->cost; ?>
  </td>
  <td>
    <?php echo $this->item->credits; ?>
  </td>
  <td>
    <?php echo $this->item->validity; ?>
  </td>  
  <td class="center">
    <?php echo JHtml::_('jgrid.published', $this->item->published, $this->i, 'packs.'); ?>
  </td>
</tr>
