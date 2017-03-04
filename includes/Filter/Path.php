<?php
namespace Redaxscript\Filter;

/**
 * children class to filter the path
 *
 * @since 2.6.0
 *
 * @package Redaxscript
 * @category Filter
 * @author Henry Ruhs
 */

class Path implements FilterInterface
{
	/**
	 * sanitize the path
	 *
	 * @since 2.6.0
	 *
	 * @param string $path target path
	 * @param string $separator directory separator
	 *
	 * @return string
	 */

	public function sanitize($path = null, $separator = '/')
	{
		$output = urldecode($path);
		$output = str_replace(
		[
			' ',
			'..',
		], null, $output);
		$output = preg_replace('~' . $separator . '+~', $separator, $output);
		$output = ltrim($output, '.');
		$output = trim($output, $separator);
		return $output;
	}
}