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

class JHtmlMediaMallFactoryMedia
{
  public static function rating($rating, $votes, $media_id, $showNull = false)
  {
    if (!$votes) {
      if ($showNull) {
        return self::simpleRating($rating);
      }

      return '';
    }

    $html = array();

    $html[] = self::simpleRating($rating);
    $html[] = $rating . '&nbsp;(<a href="'.FactoryRoute::view('media&media_id=' . $media_id . '#reviews').'">' . FactoryText::plural('media_count_reviews', $votes) . '</a>)';

    return implode("\n", $html);
  }

  public static function simpleRating($rating = 0)
  {
    FactoryHtml::stylesheet('rating');

    $html = array();
    $used = 0;

    $html[] = '<div class="rating-wrapper">';

    for ($i = 0; $i < floor($rating); $i++) {
      $html[] = '<div class="rating-star star-full"></div>';
      $used++;
    }

    if ($rating - floor($rating) >= .5) {
      $html[] = '<div class="rating-star star-half"></div>';
      $used++;
    }

    for ($i = $used; $i < 5; $i++) {
      $html[] = '<div class="rating-star star-empty"></div>';
    }

    $html[] = '</div>';

    return implode("\n", $html);
  }

  public static function mediaCountLink($id, $count)
  {
    $html = array();

    if ($count) {
      $html[] = '<span class="media_count">';
      $html[] = '(' . JHtml::_('Factory.link', 'list&filter[category]=' . $id, FactoryText::plural('media_count_files', $count)).')';
      $html[] = '</span>';
    }

    return implode("\n", $html);
  }

  public static function archiveIcon($archive = false)
  {
    $html = array();

    if ($archive) {
      $html[] = '<div class="archive-icon hasTip" title="'.FactoryText::_('media_archive_icon_title').'::'.FactoryText::_('media_archive_icon_text').'"></div>';
    }

    return implode("\n", $html);
  }

  public static function price($hasMedia, $hasArchive, $costMedia, $costArchive)
  {
    $html = array();

    if ($hasMedia && !$hasArchive) {
      $cost = $costMedia;
    } elseif (!$hasMedia && $hasArchive) {
      $cost = $costArchive;
    } else {
      $cost = min($costArchive, $costMedia);
    }

    $html[] = '<div class="price">';
    $html[] = '<div class="price-value">';

    if ($cost) {
      $html[] = FactoryText::plural('media_price_cost_credits', $cost);
    } else {
      $html[] = FactoryText::_('media_price_free_media');
    }

    $html[] = '</div>';
    $html[] = '</div>';

    return implode("\n", $html);
  }

  public static function mediaLink($id, $title)
  {
    if ('' == $title) {
      return FactoryText::_('media_removed');
    }

    $html = array();

    $html[] = '<a href="' . FactoryRoute::view('media&media_id=' . $id) . '">';
    $html[] = $title;
    $html[] = '</a>';

    return implode("\n", $html);
  }

  public static function purchaseViewsButton($cost)
  {
    $html = array();

    if ($cost) {
      $html[] = '<div class="purchase-button">';
      $html[] = '<input type="button" value="'.FactoryText::_('media_purchase_media_views').'" />';
      $html[] = '</div>';
    }

    return implode("\n", $html);
  }

  public static function thumbnail($thumbnail)
  {
    $html = array();

    $html[] = '<div class="media-photo '.($thumbnail ? '' : 'no-photo').'">';

    if ($thumbnail) {
      $html[] = '<img src="'.$thumbnail.'" />';
    }

    $html[] = '</div>';

    return implode('', $html);
  }

  public static function published($state)
  {
    $html = array();

    $classes = array(
      -1 => 'warning',
      0  => 'important',
      1  => 'success',
    );

    $texts = array(
      -1 => FactoryText::_('media_status_pending'),
      0  => FactoryText::_('media_status_unpublished'),
      1  => FactoryText::_('media_status_published'),
    );

    $html[] = '<span class="factory-label label-'.$classes[$state].'">';
    $html[] = $texts[$state];
    $html[] = '</span>';

    return implode("\n", $html);
  }

  public static function unread($count = null)
  {
    $html = array();

    if ($count) {
      $html[] = '<span class="factory-badge">'.$count.'</span>';
    }

    return implode("\n", $html);
  }

  public static function categoryPurchaseLink($category_id, $cost)
  {
    if (!$cost) {
      return '';
    }

    $currency = FactoryApplication::getInstance()->getParam('general.currency.label', 'EUR');
    $html = '<p><a href="'.FactoryRoute::task('media.purchasecategory&category_id='.$category_id).'">' . FactoryText::sprintf('category_purchase', $cost, $currency) . '</a></p>';

    return $html;
  }
}
