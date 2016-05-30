<?php
/**
 * @package     CedPrettify
 * @subpackage  com_cedprettify
 * http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL 3.0</license>
 * @copyright   Copyright (C) 2013-2016 galaxiis.com All rights reserved.
 * @license     The author and holder of the copyright of the software is Cédric Walter. The licensor and as such issuer of the license and bearer of the
 *              worldwide exclusive usage rights including the rights to reproduce, distribute and make the software available to the public
 *              in any form is Galaxiis.com
 *              see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


jimport('joomla.plugin.plugin');

class plgSystemCedPrettify extends JPlugin
{

    function plgSystemAdd2Home(& $subject, $config)
    {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

    public function onBeforeRender()
    {
        //Do not run in admin area and non HTML  (rss, json, error)
        $app = JFactory::getApplication();
        if ($app->isAdmin() || JFactory::getDocument()->getType() !== 'html')
        {
            return true;
        }

        $document = JFactory::getDocument();

        //http://jmblog.github.io/color-themes-for-google-code-prettify/
        $skins = $this->params->get('skins', 'prettify');
        $url = "?skin=prettify.css";
        if ($skins != 'prettify') {
            $url = "?skin=$skins.css";
        }

        if ($this->params->get('linenumber', true)) {
            $document->addStyleDeclaration("li.L0, li.L1, li.L2, li.L3,li.L5, li.L6, li.L7, li.L8 { list-style-type: decimal !important }");
        }

        $document->addStyleSheet(JURI::root(true) . "/media/plg_system_cedprettify/skins/$skins.css");

        $languages = $this->params->get('languages');
        if (is_array($languages)) {
            $url .= "&lang=" . implode(",", $languages);

            foreach($languages as $language) {
                $document->addScript(JURI::root(true) . "/media/plg_system_cedprettify/lang-$language.js");
            }
        } else {
            $url .= "&lang=".$languages;
            $document->addScript(JURI::root(true) . "/media/plg_system_cedprettify/lang-$languages.js");
        }

        $document->addScript(JURI::root(true) . '/media/plg_system_cedprettify/run_prettify.js' . $url);

        //$document->addScriptDeclaration("\nwindow.addEvent('domready', function() { prettyPrint();});\n");

        return;
    }

}
