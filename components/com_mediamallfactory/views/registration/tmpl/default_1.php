
<!-- Start Main Content -->
<?php  

$session =& JFactory::getSession();
$step = $session->get('step'); 
$maxSteps = (int)$session->get('maxSteps_');
$data = $session->get('data_'.$step);
?>
  <div class="title-bar"> <strong><?php echo FactoryText::_('registration_steps_1_title');?></strong> </div>
    <div class="side-holder frombox">
                        <ul class="billing-form">
                            <li>
                              <div class="control-group">
                                <label class="control-label" for="loginId"><?php echo FactoryText::_('registration_user_id');?><sup>*</sup></label>
                                <div class="controls">
                                  <input title="Identifiant" type="text" value="<?php echo $data['loginId']; ?>" id="loginId" name="loginId" class="required validate-alphanum minLength:3 maxLength:30 loginUnique">
                                </div>
                              </div>
                              
                            </li>
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="Password"><?php echo FactoryText::_('registration_user_pwd');?> <sup>*</sup></label>
                                <div class="controls">
                                  <input type="password" id="Password" name="Password" class="required validate-alphanum minLength:4">
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="confPassword"><?php echo FactoryText::_('registration_user_pwd_confirm');?> <sup>*</sup></label>
                                <div class="controls">
                                  <input type="password" id="confPassword" name="confPassword" class="required validate-match matchInput:'Password' matchName:'Password'">
                                </div>
                              </div>
                            </li>
                            <li>   
                              <div class="control-group">
                                <label class="control-label" for="inputEmail"><?php echo FactoryText::_('registration_user_email');?> <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" value="<?php echo $data['inputEmail']; ?>" id="inputEmail" name="inputEmail" class="required validate-email emailUnique">
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="confirmEmail"><?php echo FactoryText::_('registration_user_email_confirm');?> <sup>*</sup></label>
                                <div class="controls">
                                  <input type="text" value="<?php echo $data['confirmEmail']; ?>" id="confirmEmail" name="confirmEmail" class="required validate-match matchInput:'inputEmail' matchName:'E-mail'">
                                </div>
                              </div>
                            </li>
                        	<li>
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
                            </li>
                        </ul>
                </div>