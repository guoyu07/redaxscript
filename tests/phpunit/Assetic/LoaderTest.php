<?php
namespace Redaxscript\Tests\Assetic;

use Redaxscript\Assetic;
use Redaxscript\Tests\TestCaseAbstract;
use org\bovigo\vfs\vfsStream as Stream;

/**
 * LoaderTest
 *
 * @since 3.0.0
 *
 * @package Redaxscript
 * @category Tests
 * @author Henry Ruhs
 */

class LoaderTest extends TestCaseAbstract
{
	/**
	 * setUp
	 *
	 * @since 3.0.0
	 */

	public function setUp()
	{
		Stream::setup('root', 0777, $this->getProvider('tests/provider/Assetic/loader_set_up.json'));
	}

	/**
	 * providerConcat
	 *
	 * @since 3.0.0
	 *
	 * @return array
	 */

	public function providerConcat()
	{
		return $this->getProvider('tests/provider/Assetic/loader_concat.json');
	}


	/**
	 * testConcat
	 *
	 * @since 3.0.0
	 *
	 * @param array $concatArray
	 * @param string $expect
	 *
	 * @dataProvider providerConcat
	 */

	public function testConcat($concatArray = [], $expect = null)
	{
		/* setup */

		$loader = new Assetic\Loader();
		$loader
			->init()
			->concat();

		/* actual */

		/* compare */

		//$this->assertEquals($expectArray, $expectArray);
	}
}
