<?php
/**
 * @copyright   2014 Rafał Mikołajun
 * @author      Rafał Mikołajun <rafal@vision-web.pl>
 * @website     www.vision-web.pl
 * @package     Joomla System JText Plugin
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgSystemJtext extends JPlugin
{
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}

    public function onAfterRender()
    {
        $app = JFactory::getApplication();
        if($app->isSite())
        {
            $buffer = JResponse::getBody();

            $matches = array();
            $replace = array();
            $replaceWith = array();
            preg_match_all('/{jtext}(.*?){\/jtext}/i', $buffer, $matches, PREG_SET_ORDER);
            foreach ($matches as $match)
            {
                if (array_search($match[0], $replace) === false)
                {
                    $replace[] = $match[0];
                    $replaceWith[] = JText::_($match[1]);
                }
            }

            $buffer = str_replace($replace, $replaceWith, $buffer);
            JResponse::setBody($buffer);
        }
    }
}