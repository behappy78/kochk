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

class MediaMallFactoryEventMailer extends JEvent
{
  public function onMediaMallFactoryInvoiceIssued($invoiceId, $userId, $date)
  {
    // Initialize variables.
    $type = 'user_invoice_issued';
    $mailer = $this->getMailer();

    // Check if notification is enabled.
    if (!$this->isNotificationEnabled($type, $userId)) {
      return false;
    }

    // Send notification.
    return $mailer->send($type, $userId, array(
      'receiver_username' => JFactory::getUser($userId)->username,
      'date'              => $date,
    ));
  }

  public function onMediaMallFactoryMediaPurchase($mediaId, $mediaTitle, $userId, $authorId, $date)
  {
    // Initialize variables.
    $type = 'author_media_sale';
    $mailer = $this->getMailer();

    // Check if notification is enabled.
    if (!$this->isNotificationEnabled($type, $authorId)) {
      return false;
    }

    // Send notification.
    return $mailer->send($type, $authorId, array(
      'receiver_username' => JFactory::getUser($authorId)->username,
      'date'              => $date,
      'media_title'       => $mediaTitle,
    ));
  }

  public function onMediaMallFactoryCommentStore($mediaId, $userId, $date)
  {
    // Initialize variables.
    $type = 'author_received_review';
    $mailer = $this->getMailer();

    // Check if notification is enabled.
    if (!$this->isNotificationEnabled($type, $userId)) {
      return false;
    }

    // Get media.
    $media = FactoryTable::getInstance('Media');
    $media->load($mediaId);

    // Send notification.
    return $mailer->send($type, $media->user_id, array(
      'receiver_username' => JFactory::getUser($media->user_id)->username,
      'date'              => $date,
      'media_title'       => $media->title,
    ));
  }

  protected function getMailer()
  {
    static $mailer = null;

    if (is_null($mailer)) {
      $mailer = FactoryMailer::getInstance();
    }

    return $mailer;
  }

  protected function isNotificationEnabled($type, $userId)
  {
    $table = FactoryTable::getInstance('Profile');
    if (!$table->load($userId)) {
      return false;
    }

    return $table->params->get('notifications.' . $type, 0);
  }
}
