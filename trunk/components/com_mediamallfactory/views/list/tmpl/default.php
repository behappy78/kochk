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
$user =& JFactory::getUser();
if ($user->guest) {
    $session =& JFactory::getSession();
    $uri = &JURI::getInstance();
    $myabsoluteurl = $uri->toString(array('path'));
    $option =JRequest::getVar('option');
    $view =JRequest::getVar('view');
    $session->set('origpage',$myabsoluteurl);
    $session->set('option',$option);
    $session->set('view',$view);
    $app=JFactory::getApplication();
    $url=JRoute::_("http://localhost/kochk_project/index.php?option=com_users&view=login&Itemid=233");
    $app->redirect($url);
}
else {
    $id = $user->id;
    $db =& JFactory::getDBO();
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__mediamallfactory_profiles'); 
    $query->where('user_id ='.(int)$id);
    $query->where('profiled = 1');  
    $db->setQuery($query);
    //echo $db->getQuery();exit;//SQL query string  
    //check if error
    if ($db->getErrorNum()) {
      echo $db->getErrorMsg();
    }
    $results = $db->loadObjectList();
    if (!$results) {
        $app=JFactory::getApplication();
        $url=JRoute::_(JURI::base()."index.php?option=com_mediamallfactory&view=editprofile");
        $app->redirect($url, "Please Complete your profile to continue");
    }
}
?>

<div class="factory-view view-list factory-view-list">
  <h1><?php echo FactoryText::_('list_page_title'); ?></h1>
  
  <?php echo JHtml::_('Factory.beginForm', FactoryRoute::view('list')); ?>
    <?php echo $this->loadTemplate('filters'); ?>

    <?php if ($this->items): ?>
      <?php foreach ($this->items as $this->i => $this->item): ?>
        <?php echo $this->loadTemplate('item'); ?>
      <?php endforeach; ?>
    <?php else: ?>
      <p><?php echo FactoryText::_('list_no_results_found'); ?></p>
    <?php endif; ?>

    <?php echo $this->loadTemplate('pagination'); ?>
  </form>
</div>
