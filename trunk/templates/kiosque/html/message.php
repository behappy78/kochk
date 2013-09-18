<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Document
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * JDocument system message renderer
 *
 * @package     Joomla.Platform
 * @subpackage  Document
 * @since       11.1
 */
class JDocumentRendererMessage extends JDocumentRenderer
{
	/**
	 * Renders the error stack and returns the results as a string
	 *
	 * @param   string  $name     Not used.
	 * @param   array   $params   Associative array of values
	 * @param   string  $content  Not used.
	 *
	 * @return  string  The output of the script
	 *
	 * @since   11.1
	 */
	public function render($name, $params = array (), $content = null)
	{
		// Initialise variables.
		$buffer = null;
		$lists = null;
		$msgtype = null;

		// Get the message queue
		$messages = JFactory::getApplication()->getMessageQueue();

		// Build the sorted message list
		if (is_array($messages) && !empty($messages))
		{
			foreach ($messages as $msg)
			{
				if (isset($msg['type']) && isset($msg['message']))
				{
					$lists[$msg['type']][] = $msg['message'];
				}
			}
		}

		// Build the return string
		$buffer .= "<section class=\"s-holder\">";
		
		//$buffer .= "<div id=\"system-message-container\">";

		// If messages exist render them
		if (is_array($lists))
		{
			//$buffer .= "\n<dl id=\"system-message\">";
			
			foreach ($lists as $type => $msgs)
			{
				switch (strtolower($type)){
					case "message":
						$msgtype="success";
						break;
					case "notice":
						$msgtype="infos";
						break;
					case "warning":
						$msgtype="warning";
						break;
					case "error":
						$msgtype="error";
						break;
					
				}
				if (count($msgs))
				{
					
					//$buffer .= "<div class=\"alert " . strtolower($type) . "\">" . JText::_($type) . "</div>";
					$buffer .= "<div class=\"alert alert-" . strtolower($msgtype) . "\">";
					$buffer .= "<button data-dismiss=\"alert\" class=\"close\" type=\"button\">×</button>";
					$buffer .= "<strong>" . JText::_($msgtype) . "</strong>";
					$buffer .= "\n\t<ul>";
					foreach ($msgs as $msg)
					{
						$buffer .= "\n\t\t<li>" . $msg . "</li>";
					}
					$buffer .= "\n\t</ul>";
					$buffer .= "</div>";
				}
			}
			//$buffer .= "\n</dl>";
		}

		$buffer .= "</section>";
		return $buffer;
	}
}
