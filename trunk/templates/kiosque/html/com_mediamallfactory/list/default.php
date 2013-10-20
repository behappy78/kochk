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
defined ( '_JEXEC' ) or die ();
/*
 * $user =& JFactory::getUser(); if ($user->guest) { $session =& JFactory::getSession(); $uri = &JURI::getInstance(); $myabsoluteurl = $uri->toString(array('path')); $option =JRequest::getVar('option'); $view =JRequest::getVar('view'); $session->set('origpage',$myabsoluteurl); $session->set('option',$option); $session->set('view',$view); $app=JFactory::getApplication(); $url=JRoute::_("http://localhost/kochk_project/index.php?option=com_users&view=login&Itemid=233"); $app->redirect($url); } else { $id = $user->id; $db =& JFactory::getDBO(); $query = $db->getQuery(true); $query->select('*'); $query->from('#__mediamallfactory_profiles'); $query->where('user_id ='.(int)$id); $query->where('profiled = 1'); $db->setQuery($query); //echo $db->getQuery();exit;//SQL query string //check if error if ($db->getErrorNum()) { echo $db->getErrorMsg(); } $results = $db->loadObjectList(); if (!$results) { $app=JFactory::getApplication(); $url=JRoute::_(JURI::base()."index.php?option=com_mediamallfactory&view=editprofile"); $app->redirect($url, "Please Complete your profile to continue"); } }
 */
?>
<div class="heading-bar">
	<h2><?php echo FactoryText::_('list_page_title'); ?></h2>
	<span class="h-line"></span>
</div>
<section class="span12 first">
<?php echo JHtml::_('Factory.beginForm', FactoryRoute::view('list')); ?>
	<div class="product_sort">
		<div class="row-1">
			<?php echo $this->loadTemplate('filters'); ?>              
        </div>
		<!-- <div class="row-2">
			<span class="left">Items 1 to 9 of 15 total</span>
			<ul class="product_view">
				<li>View as:</li>
				<li><a href="grid-view.html" class="grid-view">Grid View</a></li>
				<li><a href="list-view.html" class="list-view">List View</a></li>
			</ul>
		</div> -->
	</div>

	<section class="grid-holder features-mags">
		<?php if ($this->items): ?>
      <?php foreach ($this->items as $this->i => $this->item): ?>
        <?php echo $this->loadTemplate('item'); ?>
      <?php endforeach; ?>
    <?php else: ?>
      <p><?php echo FactoryText::_('list_no_results_found'); ?></p>
    <?php endif; ?>

    <?php echo $this->loadTemplate('pagination'); ?>
    </section>


	</form>
</section>