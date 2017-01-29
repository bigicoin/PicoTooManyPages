<?php

/**
 * Pico "Too Many Pages" plugin - a plugin to improve load times for sites with thousands of pages
 *
 * Pico is a simple flat-file CMS, and that has many advantages, but a disadvantage is that
 * it tries to loop over every single page you have on every page load, in order to build an
 * automated pages menu.
 *
 * For large sites, this menu is often unnecessary (makes no sense to have a menu with a thousand
 * links if you have that many pages), and at 2000 pages, on a small server ($5/mo), it can take
 * up to 2 seconds to load a single page because of this loop.
 *
 * For this reason, if you have a large site you may want to disable this looping completely.
 * You won't get the "pages" array built, so you won't be able to print a menu like that, but
 * you won't lose anything else that's nice about Pico.
 *
 * @author  Bigi Lui
 * @link    https://github.com/bigicoin/PicoTooManyPages
 * @license http://opensource.org/licenses/MIT The MIT License
 * @version 1.0
 */
final class PicoTooManyPages extends AbstractPicoPlugin
{
	/**
	 * This plugin is not enabled by default
	 *
	 * @see AbstractPicoPlugin::$enabled
	 * @var boolean
	 */
	protected $enabled = false;

	/**
	 * This plugin depends on nothing
	 *
	 * @see AbstractPicoPlugin::$dependsOn
	 * @var string[]
	 */
	protected $dependsOn = array();

	protected $configCache = null;
	protected $contentDir = '';

	/**
	 * Triggered after Pico has read its configuration
	 *
	 * @see    Pico::getConfig()
	 * @param  array &$config array of config variables
	 * @return void
	 */
	public function onConfigLoaded(array &$config)
	{
		$this->configCache = &$config; // for updating later
	}

	/**
	 * Triggered before Pico reads all known pages
	 *
	 * @see    Pico::readPages()
	 * @see    DummyPlugin::onSinglePageLoaded()
	 * @see    DummyPlugin::onPagesLoaded()
	 * @return void
	 */
	public function onPagesLoading()
	{
		// we disable reading of pages by setting content_dir to a dummy directory
		$this->contentDir = $this->configCache['content_dir'];
		$this->configCache['content_dir'] = dirname(__FILE__).'/picotmp_dummy/';
	}

	/**
	 * Triggered after Pico has read all known pages
	 *
	 * See {@link DummyPlugin::onSinglePageLoaded()} for details about the
	 * structure of the page data.
	 *
	 * @see    Pico::getPages()
	 * @see    Pico::getCurrentPage()
	 * @see    Pico::getPreviousPage()
	 * @see    Pico::getNextPage()
	 * @param  array[]    &$pages        data of all known pages
	 * @param  array|null &$currentPage  data of the page being served
	 * @param  array|null &$previousPage data of the previous page
	 * @param  array|null &$nextPage     data of the next page
	 * @return void
	 */
	public function onPagesLoaded(
		array &$pages,
		array &$currentPage = null,
		array &$previousPage = null,
		array &$nextPage = null
	) {
		// set the content_dir back to normal
		$this->configCache['content_dir'] = $this->contentDir;
	}
}
