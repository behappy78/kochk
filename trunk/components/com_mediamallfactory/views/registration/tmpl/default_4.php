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
$session = JFactory::getSession();
$step = $session->get('step');
$stepD = $session->get('stepD'); 
$maxSteps = (int)$session->get('maxSteps_');
$data = $session->get('data_'.$step);
$data3 = $session->get('data_3');
?>

  <div class="title-bar"> <strong>Etape 4: Sélection du Pack</strong> </div>
    <div class="side-holder frombox">
                        <ul class="billing-form">
                        	<li>
                              <div class="control-group">
                                <label class="control-label" for="pack">Pack <sup>*</sup></label>
                                <div class="controls">
                                  <?php 
                                      $db = JFactory::getDBO();
                                      $query = $db->getQuery(true);
                                      $query->select('packs.*, curr.currency_symbol');
                                      $query->from('#__mediamallfactory_packs as packs');
                                      $query->join('inner', '#__countries as curr on curr.id = packs.currency');
                                      $query->join('inner', '#__mediamallfactory_groups as gr on gr.id = packs.country_group');
                                      $query->where('packs.published = 1 AND (country = '.$db->quote($data3['country']).' OR LOCATE('.$db->quote($data3['country']).',gr.countries))');  
                                      $query->order('id');
                                      //print_r($query);
                                      $db->setQuery($query);
                                      if ($db->getErrorNum()) {
                                        echo $db->getErrorMsg();
                                      }
                                      $results = $db->loadObjectList();
                                      
                                      //echo $country;
                                      if ($results) {
                                          foreach ($results as $result) {
                                              echo '<input type="radio" name="pack" value="'.$result->id.'">'. $result->title.' Cost: '.$result->cost.' '.$result->currency_symbol.'<br>';
                                              //print_r($results);
                                          }
                                      }
                                      else 
                                      {
                                          echo "sorry no packs are available for your country for now";
                                      } 
                                   ?>                                       	
                                   </select>
                                </div>
                              </div>
                            </li>
                        </ul>
                            	<div class="control-group">
                                <div class="controls">
                                    <?php if ($step >= 1 && $step < $maxSteps){?>
                                      <input class="more-btn" id="next" name="next" type="button" onclick="submitFormK(1);" value="<?php echo FactoryText::_('profile_button_next'); ?>" />
                                    <?php }?>
                                    <?php if ($step > 1 && $step>$stepD){?>
                                      <input class="more-btn" id="previous" name="previous" type="button" onclick="submitFormK(2);" value="<?php echo FactoryText::_('profile_button_previous'); ?>" />
                                    <?php }
                                    
                                    ?>
                                      <input class="more-btn" id="cancel" name="cancel" type="button" onclick="submitFormK(0);" value="<?php echo FactoryText::_('profile_button_cancel'); ?>" />
                                    <?php if ($step == $maxSteps){
                                    
                                        ?>   
                                	  <input class="more-btn" id="save" name="save" type="button" onclick="submitFormK(3);" value="<?php echo FactoryText::_('profile_button_apply'); ?>" />
                                	<?php } ?>
                                </div>
                              </div>
                </div>

