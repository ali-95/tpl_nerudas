<?php
/**
 * @package    Nerudas Template
 * @version    5.0.0
 * @author     Nerudas  - nerudas.ru
 * @copyright  Copyright (c) 2013 - 2017 Nerudas. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link       https://nerudas.ru
 */

defined('_JEXEC') or die;


use Joomla\Registry\Registry;

class tplNerudasHelper
{

	/**
	 * Set tempalte head
	 *
	 * @param $params JObject $params Template params
	 *
	 * @since   1.0.0
	 */
	public function setHead($params)
	{
		$doc = JFactory::getDocument();

		// Template params
		$minified = $params->get('minified', '');

		// Add GoogleFonts
		$doc->addStyleSheet('https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600&subset=cyrillic,cyrillic-ext');

		// Add jQuery
		$this->addjQuery($minified);

		// Add UIkit
		$this->addUIkit($minified);

		// Add Template
		$this->addTemplate($minified);

		// Set meta viewport
		$doc->setMetaData('viewport', 'width=device-width, initial-scale=1, minimum-scale=1');
	}

	/**
	 * Add jQuery to head
	 *
	 * @param string $minified .min minified
	 *
	 * @since   1.0.0
	 */
	protected function addjQuery($minified)
	{
		JHtml::_('jquery.framework');
		$doc  = JFactory::getDocument();
		$head = $doc->getHeadData();

		// Prepare params
		$scripts = $head['scripts'];
		$params  = $scripts['/media/jui/js/jquery.min.js'];
		$path    = '/templates/' . JFactory::getApplication()->getTemplate() . '/js/jquery' . $minified . '.js';

		// Uset joomla jquery
		unset(
			$scripts['/media/jui/js/jquery.min.js'],
			$scripts['/media/jui/js/jquery-noconflict.js'],
			$scripts['/media/jui/js/jquery-migrate.min.js']
		);

		$head ['scripts'] = array($path => $params) + $scripts;

		$doc->setHeadData($head);
	}

	/**
	 * Add UIkit to head
	 *
	 * @param string $minified .min minified
	 *
	 * @since   1.0.0
	 */
	protected function addUIkit($minified)
	{
		JHtml::_('stylesheet', 'uikit' . $minified . '.css', array('version' => 'auto', 'relative' => true));
		JHtml::_('script', 'uikit' . $minified . '.js', array('version' => 'auto', 'relative' => true));
		JHtml::_('script', 'uikit-icons' . $minified . '.js', array('version' => 'auto', 'relative' => true));
	}

	/**
	 * Add tempalte to head
	 *
	 * @param string $minified .min minified
	 *
	 * @since   1.0.0
	 */
	protected function addTemplate($minified)
	{
		JHtml::_('stylesheet', 'template' . $minified . '.css', array('version' => 'auto', 'relative' => true));
		JHtml::_('script', 'template' . $minified . '.js', array('version' => 'auto', 'relative' => true));
		JHtml::_('script', 'template-icons' . $minified . '.js', array('version' => 'auto', 'relative' => true));
	}

	/**
	 * Check if beta version of site
	 *
	 * @param $params JObject $params Template params
	 *
	 * @return boolean
	 *
	 * @since   1.0.0
	 */
	public function checkBetaVersion($params)
	{
		if (!preg_match('/nerudas.ru/', (JURI::base())))
		{
			$doc = JFactory::getDocument();
			$doc->setMetaData('robots', 'noindex');
			$doc->addHeadLink(str_replace('beta.', '', JUri::getInstance()->toString()), 'canonical');
			$doc->setTitle('[BETA] ' . $doc->getTitle());
			$params->set('minified', '');

			return true;
		}


		return false;
	}

	/**
	 * Unset joomla default bootstrap framework form head
	 *
	 * @since   1.0.0
	 */
	public function unsetBootstrap()
	{
		$doc     = JFactory::getDocument();
		$head    = $doc->getHeadData();
		$scripts = $head['scripts'];

		// Uset bootstra
		unset($scripts['/media/jui/js/bootstrap.min.js']);

		$head['scripts'] = $scripts;
		$doc->setHeadData($head);
	}

	/**
	 * Check if beta version of site
	 *
	 * @param $params JObject $params Template params
	 *
	 * @return stdClass header data
	 *
	 * @since   1.0.0
	 */
	public function prepareHeader($params)
	{

		$logo = $params->get('logo', '');
		if ($logo)
		{
			$logo = new Registry($logo);

		}

		$header       = new stdClass();
		$header->logo = false;
		if ($logo)
		{
			$header->logo         = new stdClass();
			$header->logo->src    = $logo->get('src', 'templates/nerudas/images/logo.svg');
			$header->logo->alt    = $logo->get('alt', JFactory::getConfig()->get('sitename'));
			$header->logo->type   = JFile::getExt($header->logo->src);
			$header->logo->height = $logo->get('height', 0);
			$header->logo->class  = $logo->get('class', '');

			// Attributes
			$header->logo->attributes = '';
			if (!empty($header->logo->height))
			{
				$header->logo->attributes = ' height="' . $header->logo->height . '"';
			}
			if (!empty($header->logo->class))
			{
				$header->logo->attributes = ' class="' . $header->logo->class . '"';
			}
			if ($header->logo->type == 'svg')
			{
				$header->logo->attributes .= ' data-uk-svg';
			}

			// Element
			$header->logo->element = '<img src="/' . $header->logo->src . '" alt="' . $header->logo->alt . '"' . $header->logo->attributes . '>';
			if ($header->logo->type == 'svg')
			{
				$header->logo->element = JFile::read($header->logo->src);
			}

		}

		return $header;
	}
}