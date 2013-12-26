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
    <a href="<?php echo FactoryRoute::view('edition&id=' . $this->item->id); ?>"><?php echo '<img height="50px" src="' .JURI::root(). $this->item->thumbnail. '" alt="-" />'; ?></a>
	</td>
  <td>
    <a href="<?php echo FactoryRoute::view('edition&id=' . $this->item->id); ?>"><?php echo $this->item->title; ?></a>
	</td>

  <td class="center">
    <?php echo $this->item->c2title; ?>
  </td>

  <td>
    <?php echo $this->item->icountryn; ?>
  </td>
  <td>
    <?php 
    if (strlen($this->item->incountries) > 140)
    {
    	$ctrs = '';
    	for ($i = 0; $i < strlen($this->item->incountries) % 120; $i++) {
    		$ctrs .= substr($this->item->incountries, $i * 140, 140).PHP_EOL;
    	}
    	echo $ctrs;
    }
    else
    	echo $this->item->incountries; ?>  
  </td>
  <td>
    <?php echo $this->item->ecountryn; ?>
  </td>  
  <td>
    <?php 
    if (strlen($this->item->excountries) > 140)
    {
    	$ctrs = '';
    	for ($i = 0; $i < strlen($this->item->excountries) % 120; $i++) {
    		$ctrs .= substr($this->item->excountries, $i * 140, 140).PHP_EOL;
    	}
    	echo $ctrs;
    }
    else
    	echo $this->item->excountries; ?> 
  </td>  

  <td class="center">
    <?php echo JHtml::_('jgrid.published', $this->item->published, $this->i, 'editions.'); ?>
  </td>
</tr>
