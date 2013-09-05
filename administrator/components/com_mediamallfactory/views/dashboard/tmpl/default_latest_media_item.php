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
  <td><a href="<?php echo FactoryRoute::view('media&media_id=' . $this->media->id); ?>"><?php echo $this->media->title; ?></a></td>
  <td><?php echo $this->media->category_title; ?></td>
  <td><?php echo $this->media->type_title; ?></td>
  <td><a href="#"><?php echo $this->media->username; ?></a></td>
  <td><?php echo JHtml::_('MediaMallFactory.date', $this->media->created_at); ?></td>
</tr>
