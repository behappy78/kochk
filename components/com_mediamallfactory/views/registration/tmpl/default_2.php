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
//<form class="form-horizontal register-vcode">
//</form>
?> 
  <?php 
$session =& JFactory::getSession();
$step = $session->get('step'); 
$maxSteps = (int)$session->get('maxSteps_');
  ?>
  <div class="title-bar"> <strong><?php echo FactoryText::_('registration_steps_2_title');?></strong> </div>
    <div class="side-holder frombox center">
                	<p><?php echo FactoryText::_('to_do_next_registration_steps_1');?> <em><?php echo FactoryText::_('registration_validation_code');?></em> <?php echo FactoryText::_('to_do_next_registration_steps_2');?></p>
                    
                              <div class="control-group">
                                <label class="control-label" for="verifVcode"><?php echo FactoryText::_('registration_validation_code');?></label>
                                <div class="controls">
                                  <input type="text" id="verifVcode" name="verifVcode" class="center required validate-alphanum mailCode">
                                </div>
                              </div>                           
                            
                            	<div class="control-group">
                                <div class="controls">
                                    <?php if ($step >= 1 && $step < $maxSteps){?>
                                      <input class="more-btn" id="next" name="next" type="button" onclick="submitFormK(1);" value="<?php echo FactoryText::_('profile_button_next'); ?>" />
                                    <?php }?>
                                    <?php if ($step > 1){?>
                                      <input class="more-btn" id="previous" name="previous" type="button" onclick="submitFormK(2);" value="<?php echo FactoryText::_('profile_button_previous'); ?>" />
                                    <?php }?>
                                      <input class="more-btn" id="cancel" name="cancel" type="button" onclick="submitFormK(0);" value="<?php echo FactoryText::_('profile_button_cancel'); ?>" />
                                    <?php if ($step == $maxSteps){?>            
                                	  <input class="more-btn" id="save" name="save" type="button" onclick="submitFormK(3);" value="<?php echo FactoryText::_('profile_button_apply'); ?>" />
                                	<?php } ?>
                                </div>
                              </div>
                    
                </div>

