<?php
/**
 * @package     CedPrettify
 * @subpackage  com_cedprettify
 *
 * @copyright   Copyright (C) 2013-2016 galaxiis.com All rights reserved.
 * @license     The author and holder of the copyright of the software is Cédric Walter. The licensor and as such issuer of the license and bearer of the
 *              worldwide exclusive usage rights including the rights to reproduce, distribute and make the software available to the public
 *              in any form is Galaxiis.com
 *              see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class PlgButtonCedPrettify extends JPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;

	/**
	 * CedPretiffy button
	 *
	 * @param   string  $name  The name of the button to add
	 *
	 * @return array A two element array of (imageName, textToInsert)
	 */
	public function onDisplay($name)
	{
		$doc = JFactory::getDocument();

		// Button is not active in specific content components

		$getContent = $this->_subject->getContent($name);
		$js = "
			function insertCedPrettify(editor)
			{
				var content = $getContent
     			jInsertEditorText('<pre class=\"prettyprint\">source code here</pre>', editor);
			}
			";

		$doc->addScriptDeclaration($js);

		$button = new JObject;
		$button->modal = false;
		$button->class = 'btn';
		$button->onclick = 'insertCedPrettify(\'' . $name . '\');return false;';
		$button->text = "CedPrettify";
		$button->name = 'arrow-down';

		// @TODO: The button writer needs to take into account the javascript directive
		// $button->link', 'javascript:void(0)');
		$button->link = '#';

		return $button;
	}
}
