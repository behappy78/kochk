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

<div class="heading-bar">
	<h2><?php echo FactoryText::_('dashboard_page_title'); ?></h2>
	<span class="h-line"></span>
</div>
<section class="span9 first">
	<section class="grid-holder features-mags">
	<?php if ($this->items): ?>
	<?php $this->mdlo = 0;?>
      <?php foreach ($this->items as $this->i => $this->item): ?>

        <?php echo $this->loadTemplate('item'); ?>
        <?php ++$this->mdlo;?>
        <?php 
        	//echo $this->item->view."</br>";
        	//print_r($this->item);
        	//echo "</br>"
        ?>
      <?php endforeach; ?>
    <?php else: ?>
      <p><?php echo FactoryText::_('no_results_found'); ?></p>
    <?php endif; ?>
	</section>

</section>
<section class="span3">
	<div class="side-holder">
				<article class="price-range">
						<h2>Achat Rapide de Crédits</h2>
                    
	                    <div class="side-inner-holder">
	                    	<p>Selectionnez le nombre de crédits que vou souhaitez acheter:</p>                    	
	                        <div id="slider-range" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false"><div class="ui-slider-range ui-widget-header ui-corner-all" style="left: 15%; width: 45%;"></div><a href="#" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 15%;"></a><a href="#" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 60%;"></a></div>
	                        <p> <input type="text" class="r-input" id="amount"> </p>
	                    </div>
                </article>
            	<article class="price-range">
                	<h2>Dernières Activités</h2>
                		<div class="side-inner-holder">
	                    	<strong class="title">Récements Achetés (15)</strong>
	                    	<ul class="side-list">
	                        	<li><a href="grid-view.html">LaPresse du 19/10/2013</a></li>
	                            <li><a href="grid-view.html">AL-Chourouk du 19/10/2013</a></li>
	                            <li><a href="grid-view.html">Le Tempp du 19/10/2013</a></li>
	                            <li><a href="grid-view.html">Al-Fajr Du 15/10/2013</a></li>
	                        </ul>	                      
	                    </div>
                    </article>                    
            </div>
</section>