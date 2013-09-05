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

<OBJECT ID="MediaPlayer" WIDTH="192" HEIGHT="190" CLASSID="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95" STANDBY="Loading Windows Media Player components..." TYPE="application/x-oleobject">
  <PARAM NAME="FileName" VALUE="<?php echo $this->getSource(); ?>">
  <PARAM name="autostart" VALUE="false">
  <PARAM name="ShowControls" VALUE="true">
  <param name="ShowStatusBar" value="false">
  <PARAM name="ShowDisplay" VALUE="false">
  <EMBED TYPE="application/x-mplayer2" SRC="<?php echo $this->getSource(); ?>" NAME="MediaPlayer" WIDTH="425" HEIGHT="300" ShowControls="1" ShowStatusBar="0" ShowDisplay="0" autostart="0"> </EMBED>
</OBJECT>
