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

<figure class="span3 slide <?php echo $this->i % 4 ? '' : 'first'; ?>">
	<?php echo JHtml::_('Factory.link', 'media&media_id=' . $this->item->id, '<img src="'.$this->item->thumbnail.'">'); ?>
	<span class="title">
	<?php echo JHtml::_('Factory.link', 'media&media_id=' . $this->item->id, $this->item->title); ?>
	</span>
	<span class="rating-bar">
	<?php echo JHtml::_('MediaMallFactoryMedia.rating', $this->item->rating, $this->item->votes, $this->item->id); ?>
	</span>
	<div class="cart-price">
		<a class="cart-btn2" href="#">Crédits</a>
		<?php echo JHtml::_('MediaMallFactoryMedia.price', $this->item->has_media, $this->item->has_archive, $this->item->cost_media, $this->item->cost_archive); ?>
	</div>

</figure>
