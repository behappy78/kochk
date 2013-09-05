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

<ol class="mod_mediamallfactory<?php echo $moduleclass_sfx; ?>">
  <?php foreach ($list as $item): ?>
    <li>
      <a href="<?php echo FactoryRoute::view('media&media_id=' . $item->id); ?>"><?php echo $item->title; ?></a>
      <div class="extra-info"><?php require JModuleHelper::getLayoutPath('mod_mediamallfactory', $params->get('mode', 'latest')); ?></div>
    </li>
  <?php endforeach; ?>
</ol>
