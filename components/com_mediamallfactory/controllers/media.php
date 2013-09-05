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

class MediaMallFactoryFrontendControllerMedia extends JController
{
  public function __construct($config = array())
  {
    parent::__construct($config);

    $this->registerTask('apply', 'save');
    $this->registerTask('save2new', 'save');
  }

  public function save()
  {
    JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

    $app     = JFactory::getApplication();
    $data    = JFactory::getApplication()->input->post->get('media', array(), 'array');
    $model   = $this->getModel('Edit');
    $option  = FactoryApplication::getInstance()->getOption();
    $context = $option.'.edit.edit.data';
    $id      = JFactory::getApplication()->input->get->getInt('media_id', 0);

    $app->setUserState($context, null);

    // Prepare files post
    $data = array_merge($data, JFactory::getApplication()->input->files->get('media'));
    $data['id'] = $id;

    if ($model->save($data)) {
      $msg = FactoryText::_('media_save_success');
    } else {
      $msg = FactoryText::_('media_save_error');

      $app->setUserState($context, $data);

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'warning');
      }

      $media_id = $id ? '&media_id='.$id : '';
      $this->setRedirect(FactoryRoute::view('edit'.$media_id), $msg);

      return false;
    }

    $redirect = FactoryRoute::view('mediastats');

    if ('apply' == $this->getTask()) {
      $redirect = FactoryRoute::view('edit&media_id=' . $model->getState('media_id'));
    } else if ('save2new' == $this->getTask()) {
      $redirect = FactoryRoute::view('edit');
    }

    $this->setRedirect($redirect, $msg);

    return true;
  }

  public function cancel()
  {
    $this->setRedirect(FactoryRoute::view('list'));
  }

  public function download()
  {
    // Initialize variables.
    $app      = JFactory::getApplication();
    $user_id  = JFactory::getUser()->id;
    $media_id = $app->input->get->getInt('media_id', 0);
    $type     = $app->input->get->getCmd('type', 'media');
    $model    = $this->getModel('Media');

    // Check if type is valid.
    if (!in_array($type, array('media', 'archive'))) {
      throw new Exception(FactoryText::_('media_download_error_type_not_supported'), 404);
    }

    // Get the media.
    $media = $model->getItem($media_id);

    // Check if user is allowed to view media.
    if (false === $purchase = $media->isAllowedToView($type, $user_id)) {
      throw new Exception(FactoryText::_('media_media_view_error_not_allowed'), 403);
      return false;
    }

    // Send media to user.
    $media->download($type);

    // Update media views.
    if ($purchase instanceof MediaMallFactoryTablePurchase) {
      $purchase->updateViews();
    }

    // Trigger media download event.
    FactoryApplication::getInstance()->trigger('mediaDownload', array(
      $media_id, $user_id, $type
    ));

    jexit();
  }

  public function purchase()
  {
    $app      = JFactory::getApplication();
    $media_id = $app->input->get->getInt('media_id', 0);
    $user_id  = JFactory::getUser()->id;
    $model    = $this->getModel('Media');
    $type     = $app->input->get->getCmd('type', 'media');

    if ($model->purchase($media_id, $user_id, $type)) {
      $msg = FactoryText::_('media_purchase_'.$type.'_success');
    } else {
      $msg = FactoryText::_('media_purchase_'.$type.'_error');

      $app->enqueueMessage($model->getError(), 'error');
    }

    $this->setRedirect(FactoryRoute::view('media&media_id=' . $media_id), $msg);
  }

  public function purchaseCategory()
  {
    $app      = JFactory::getApplication();
    $category_id = $app->input->get->getInt('category_id', 0);
    $user_id  = JFactory::getUser()->id;
    $model    = $this->getModel('Media');

    $category_sale = FactoryApplication::getInstance()->getParam('general.global.category_sale', 0);
    if (!$category_sale) {
      throw new Exception(FactoryText::_('media_purchase_category_not_allowed'), 403);
    }

    if ($model->purchaseCategory($category_id, $user_id)) {
      $msg = FactoryText::_('media_categorypurchase_success');
    } else {
      $msg = FactoryText::_('media_categorypurchase_error');

      $app->enqueueMessage($model->getError(), 'error');
    }

    $this->setRedirect(FactoryRoute::view('categories&category_id=' . $category_id), $msg);
  }

  public function delete()
  {
    $app   = JFactory::getApplication();
    $batch = $app->input->post->get('batch', array(), 'array');
    $model = $this->getModel('Edit');

    if ($model->delete($batch)) {
      $msg = FactoryText::_('edit_delete_success');
    } else {
      $msg = FactoryText::_('edit_delete_error');

      foreach ($model->getErrors() as $error) {
        $app->enqueueMessage($error, 'warning');
      }
    }

    $this->setRedirect(FactoryRoute::view('mediastats'), $msg);
  }

  public function authorise($task)
  {
    if (!parent::authorise($task)) {
      return false;
    }

    $permissions = array(
      'save'     => array('logged', 'author', 'limitedUploads'),
      'cancel'   => array('logged', 'author'),
      'download' => array(),
      'purchase' => array('logged'),
      'purchaseCategory' => array('logged'),
      'delete'   => array('logged', 'author'),
    );

    $free_media_guests = FactoryApplication::getInstance()->getParam('general.global.free_media_guests', 1);
    if (!$free_media_guests) {
      $permissions['download'][] = 'logged';
    }

    foreach ($permissions[$task] as $permission) {
      FactoryApplication::getInstance()->checkPermission($permission);
    }

    return true;
  }
}
