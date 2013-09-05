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

<script type="text/javascript">
  AudioPlayer.setup('<?php echo $this->swf; ?>', {
    width: '100%',
    transparentpagebg: 'yes',
    animation: 'no',
    noinfo: 'yes',
    initialvolume: 25
  });
</script>

<p id="audioplayer_1">Alternative content</p>
<script type="text/javascript">
  AudioPlayer.embed("audioplayer_1", {soundFile: "<?php echo urlencode($this->getSource()); ?>"});
</script>
