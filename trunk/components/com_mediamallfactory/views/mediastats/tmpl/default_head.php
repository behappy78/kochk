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

<thead>
  <tr>
    <th width="10px"><input type="checkbox" /></th>
    <th><?php echo FactoryText::_('mediastats_list_media'); ?></th>
    <th width="80px"></th>
    <th width="50px" class="center"><?php echo FactoryText::_('mediastats_list_amount'); ?></th>
    <th width="50px" class="center"><?php echo FactoryText::_('mediastats_list_sales'); ?></th>
<!--    <th width="100px">--><?php //echo FactoryText::_('mediastats_list_type'); ?><!--</th>-->
    <th width="100px"><?php echo FactoryText::_('mediastats_list_status'); ?></th>
    <th width="150px"><?php echo FactoryText::_('mediastats_list_date'); ?></th>
  </tr>
</thead>