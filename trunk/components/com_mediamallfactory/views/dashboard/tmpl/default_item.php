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
<?php if ($this->item[image] != ""):

	$ismutiple = $this->mdlo % 6;
	if ($ismutiple == 0) {
		$firstclass = 'first';
	}else {
		$firstclass = '';
}
?>
<figure class="span2 slide <?php echo $firstclass; ?>">
	<?php //echo JHtml::_('icons.button', $this->item);
	//echo $this->mdlo;
	echo JHtml::_('Factory.link', $this->item[view] , '<img src="'.$this->item['image'].'"><center>'.$this->item[view].'</center>');
	
	?>
	
	
	<span class="title" style="text-align:center">	
	<?php //echo JHtml::_('Factory.link', $this->item[view], $this->item-['text']); ?>
	</span>

</figure>
<?php endif;?>
