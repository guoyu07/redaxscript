<?php
include_once('tests/stubs.php');

/**
 * Redaxscript Parser Test
 *
 * @since 2.1.0
 *
 * @package Redaxscript
 * @category Tests
 * @author Henry Ruhs
 */

class Redaxscript_Parser_Test extends PHPUnit_Framework_TestCase
{
	/**
	 * instance of the registry class
	 *
	 * @var object
	 */

	protected $_registry;

	/**
	 * instance of the language class
	 *
	 * @var object
	 */

	protected $_language;
	/**
	 * setUp
	 *
	 * @since 2.1.0
	 */

	protected function setUp()
	{
		$this->_registry = Redaxscript_Registry::getInstance();
		$this->_language = Redaxscript_Language::getInstance();
	}

	/**
	 * providerParser
	 *
	 * @since 2.1.0
	 *
	 * @return array
	 */

	public function providerParser()
	{
		$contents = file_get_contents('tests/provider/parser.json');
		$output = json_decode($contents, true);
		return $output;
	}

	/**
	 * testParseBreak
	 *
	 * @since 2.1.0
	 *
	 * @param array $registry
	 * @param string $text
	 * @param string $route
	 * @param string $expect
	 *
	 * @dataProvider providerParser
	 */

	public function testParseBreak($registry = array(), $text = null, $route = null, $expect = null)
	{
		/* setup */

		$this->_registry->init($registry);
		$options = array(
			'classString' => array(
				'break' => 'link-read-more',
				'code' => 'box-code'
			)
		);
		$parser = new Redaxscript_Parser($this->_registry, $this->_language, $text, $route, $options);

		/* result */

		$result = $parser->getOutput();

		/* compare */

		$this->assertEquals($expect, $result);
	}
}
