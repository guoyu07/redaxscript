<?php
namespace Redaxscript\Html;

/**
 * abstract class to create html
 *
 * @since 2.6.0
 *
 * @package Redaxscript
 * @category Html
 * @author Henry Ruhs
 */

abstract class HtmlAbstract
{
	/**
	 * html of the element
	 *
	 * @var string
	 */

	protected $_html;

	/**
	 * set the html
	 *
	 * @since 2.6.0
	 *
	 * @param string $html html to set
	 *
	 * @return Element
	 */

	public function html($html = null)
	{
		$this->_html = $html;
		return $this;
	}

	/**
	 * append to the html
	 *
	 * @since 2.6.0
	 *
	 * @param string $html html to append
	 *
	 * @return Element
	 */

	public function append($html = null)
	{
		$this->_html .= $html;
		return $this;
	}

	/**
	 * prepend to the html
	 *
	 * @since 2.6.0
	 *
	 * @param string $html html to prepend
	 *
	 * @return Element
	 */

	public function prepend($html = null)
	{
		$this->_html = $html . $this->_html;
		return $this;
	}

	/**
	 * clear the html
	 *
	 * @since 3.0.0
	 *
	 * @return Element
	 */

	public function clear()
	{
		$this->html(null);
		return $this;
	}
}
