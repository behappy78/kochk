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

<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" height="300" width="425">

<param name="src" value="<?php echo $this->getSource(); ?>">
<param name="autoplay" value="false">
<param name="type" value="video/quicktime" height="300" width="425">

<embed src="<?php echo $this->getSource(); ?>" height="300" width="425" autoplay="false" type="video/quicktime" pluginspage="http://www.apple.com/quicktime/download/">

</object>
