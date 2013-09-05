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

<div id="flow-player"></div>

<script type="text/javascript">
  flowplayer('flow-player', {
    src: '<?php echo $this->swf; ?>',
    wmode: 'direct'
  }, {
    plugins: {
      controls: {
        buttonColor: 'rgba(0, 0, 0, 0.9)',
        buttonOverColor: '#000000',
        backgroundColor: '#D7D7D7',
        backgroundGradient: 'medium',
        sliderColor: '#FFFFFF',

        sliderBorder: '1px solid #808080',
        volumeSliderColor: '#FFFFFF',
        volumeBorder: '1px solid #808080',

        timeColor: '#000000',
        durationColor: '#535353'
      }
    },
    clip: {
      autoPlay: false,
      accelerated: true,
      url: '<?php echo urlencode($this->getSource()); ?>'
     }
  });
</script>
