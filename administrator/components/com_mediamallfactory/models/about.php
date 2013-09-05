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

class MediaMallFactoryBackendModelAbout extends JModel
{
  protected $option   = 'com_mediamall';
  protected $base     = 'http://thefactory.ro/versions/';
  protected $manifest = null;

  public function __construct($config = array())
  {
    parent::__construct($config);

    $this->manifest = $this->getManifest();
  }

  public function getAbout()
  {
    $information = new stdClass();

    $information->currentVersion = $this->getCurrentVersion();
    $information->latestVersion  = $this->getLatestVersion();
    $information->newVersion     = $this->getNewVersion($information->currentVersion, $information->latestVersion);
    $information->versionHistory = (string)$this->manifest->versionhistory;
    $information->downloadLink   = (string)$this->manifest->downloadlink;
    $information->otherProducts  = (string)$this->manifest->otherproducts;
    $information->aboutFactory   = (string)$this->manifest->aboutfactory;

    return $information;
  }

  protected function getCurrentVersion()
  {
    jimport('joomla.filesystem.file');

    $file = JPATH_COMPONENT_ADMINISTRATOR.DS.'mediamallfactory.xml';

    $data = JApplicationHelper::parseXMLInstallFile($file);

    return $data['version'];
  }

  protected function getLatestVersion()
  {
    return (string)$this->manifest->latestversion;
  }

  protected function getNewVersion($current, $latest)
  {
    list($currentMajor, $currentMinor, $currentBuild) = explode('.', $current);
    list($latestMajor, $latestMinor, $latestBuild)    = explode('.', $latest);

    if (intval($latestMajor) > intval($currentMajor)) {
      return true;
    } elseif (intval($latestMinor) > intval($currentMinor)) {
      return true;
    } elseif (intval($latestBuild) > intval($currentBuild)) {
      return true;
    }

    return false;
  }

  protected function getManifest()
  {
    if (is_null($this->manifest)) {
      $contents = $this->fileGetContents();

      if (false === $contents) {
        JError::raiseError(500, 'There was an error retrieving the information from the server. Please try again later!');
      }

      $this->manifest = JFactory::getXML($contents, false);
    }

    return $this->manifest;
  }

  protected function fileGetContents()
  {
    static $contents = null;

    if (is_null($contents)) {
      $filename = $this->base . $this->option . '.xml';

      if (function_exists('curl_init')) {
        $contents = $this->getContentsCurl($filename);
      }
      elseif (ini_get('allow_url_fopen')) {
        $contents = $this->getContentsRead($filename);
      } else {
        $contents = false;
      }
    }

    return $contents;
  }

  protected function getContentsCurl($filename)
  {
    $handle = curl_init();

    curl_setopt ($handle, CURLOPT_URL,            $filename);
    curl_setopt ($handle, CURLOPT_MAXREDIRS,      5);
    curl_setopt ($handle, CURLOPT_AUTOREFERER,    1);
    curl_setopt ($handle, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt ($handle, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt ($handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($handle, CURLOPT_TIMEOUT,        10);

    $buffer = curl_exec($handle);
    curl_close($handle);

    return $buffer;
  }

  protected function getContentsRead($filename)
  {
    $fp = fopen($filename, 'r');

    if (!$fp) {
      return false;
    }

    stream_set_timeout($fp, 20);
    $linea = '';
    while ($remote_read = fread($fp, 4096)) {
      $linea .= $remote_read;
    }

    $info = stream_get_meta_data($fp);
    fclose($fp);

    if ($info['timed_out']) {
      return false;
    }

    return $linea;
  }
}
