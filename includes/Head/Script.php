<?php
namespace Redaxscript\Head;

use Redaxscript\Asset;
use Redaxscript\Html;
use Redaxscript\Registry;
use Redaxscript\Language;

/**
 * children class to create the script tag
 *
 * @since 3.0.0
 *
 * @package Redaxscript
 * @category Head
 * @author Henry Ruhs
 *
 * @method append($attribute = null, $value = null)
 * @method prepend($attribute = null, $value = null)
 */

class Script extends HeadAbstract
{
	/**
	 * options of the script
	 *
	 * @var string
	 */

	protected static $_optionArray =
	[
		'directory' => 'cache/scripts',
		'extension' => 'js',
		'attribute' => 'src',
		'lifetime' => 86400
	];

	/**
	 * inline script
	 *
	 * @var string
	 */

	protected static $_inline = null;

	/**
	 * append script file
	 *
	 * @since 3.0.0
	 *
	 * @param string $source
	 *
	 * @return Script
	 */

	public function appendFile($source = null)
	{
		$this->append('src', $source);
		return $this;
	}

	/**
	 * prepend script file
	 *
	 * @since 3.0.0
	 *
	 * @param string $source
	 *
	 * @return Script
	 */

	public function prependFile($source = null)
	{
		$this->prepend('src', $source);
		return $this;
	}

	/**
	 * remove script file
	 *
	 * @since 3.0.0
	 *
	 * @param string $source
	 *
	 * @return Script
	 */

	public function removeFile($source = null)
	{
		$this->remove('src', $source);
		return $this;
	}

	/**
	 * append inline script
	 *
	 * @since 3.0.0
	 *
	 * @param string $inline
	 *
	 * @return Script
	 */

	public function appendInline($inline = null)
	{
		self::$_inline .= $inline;
		return $this;
	}

	/**
	 * prepend inline script
	 *
	 * @since 3.0.0
	 *
	 * @param string $inline
	 *
	 * @return Script
	 */

	public function prependInline($inline = null)
	{
		self::$_inline = $inline . self::$_inline;
		return $this;
	}

	/**
	 * transport javascript variables
	 *
	 * @since 3.0.0
	 *
	 * @param string $key
	 * @param mixed $value
	 *
	 * @return Script
	 */

	public function transportVar($key = null, $value = null)
	{
		$transport = new Asset\Transport(Registry::getInstance(), Language::getInstance());
		$inline = $transport->render($key, $value);
		$this->appendInline($inline);
		return $this;
	}

	/**
	 * concat the script
	 *
	 * @since 3.0.0
	 *
	 * @param array $optionArray
	 *
	 * @return Script
	 */

	public function concat($optionArray = [])
	{
		$optionArray = array_merge(self::$_optionArray, $optionArray);
		$loader = new Asset\Loader(Registry::getInstance());
		$loader
			->init(self::$_collectionArray[self::$_namespace])
			->concat($optionArray);

		/* update collection */

		self::$_collectionArray[self::$_namespace] = $loader->getCollectionArray();
		return $this;
	}

	/**
	 * render the script
	 *
	 * @since 3.0.0
	 *
	 * @return string
	 */

	public function render()
	{
		$output = null;

		/* html elements */

		$scriptElement = new Html\Element();
		$scriptElement->init('script');
		$collectionArray = self::$_collectionArray[self::$_namespace];
		$collectionKeys = array_keys($collectionArray);
		$lastKey = end($collectionKeys);

		/* process collection */

		foreach ($collectionArray as $key => $attribute)
		{
			$output .= $scriptElement
				->copy()
				->attr($attribute);
			if ($key !== $lastKey || self::$_inline)
			{
				$output .= PHP_EOL;
			}
		}

		/* collect inline */

		if (self::$_inline)
		{
			$output .= $scriptElement
				->copy()
				->text(self::$_inline);
		}
		$this->clear();
		return $output;
	}

	/**
	 * clear the script
	 *
	 * @since 3.0.0
	 *
	 * @return Script
	 */

	public function clear()
	{
		parent::clear();
		self::$_inline = null;
		return $this;
	}
}