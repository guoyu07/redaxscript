<?php
namespace Redaxscript\Detector;

use Redaxscript\Db;
use Redaxscript\Request;

/**
 * children class to detect the required template
 *
 * @since 2.0.0
 *
 * @category Detector
 * @package Redaxscript
 * @author Henry Ruhs
 */

class Template extends Detector
{
	/**
	 * init the class
	 *
	 * @since 2.1.0
	 */

	public function init()
	{
		$this->_detect(array(
			'query' => Request::getQuery('t'),
			'session' => Request::getSession($this->_registry->get('root') . '/template'),
			'contents' => $this->_registry->get('lastTable') ? Db::forPrefixTable($this->_registry->get('lastTable'))->where('id', $this->_registry->get('lastId'))->findOne()->template : null,
			'settings' => Db::getSettings('template'),
			'fallback' => 'default'
		), 'template', 'templates/{value}/index.phtml');
	}
}