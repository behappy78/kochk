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

defined('_JEXEC') or die; 
$link = FactoryRoute::view('registration');
$link .= "&format=raw"; 

?>

<div class="factory-view view-profile factory-view-edit">
  <h1><?php echo FactoryText::_('register_page_title'); ?></h1>

  <form action="<?php echo $link; ?>" id="adminForm" name="adminForm" method="post" class="form-validate">
    <?php //echo $this->loadTemplate('buttons'); ?>
	<div id="kochkmain">
	<?php echo "default 1";?>
	</div>
    <?php
      echo "dqsdqsdqsdqsdqsd";
        $session =& JFactory::getSession();
	    $step = $session->get('step'); 
	    $maxSteps = (int)$session->get('maxSteps_');
        if ($step == 1)
         echo $this->loadTemplate('buttons1');
        else 
            if ($step == $maxSteps)
             echo $this->loadTemplate('buttons2');
            else 
             echo $this->loadTemplate('buttons');
         
         print_r($step);
    ?>
	
    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
  </form>
</div>
