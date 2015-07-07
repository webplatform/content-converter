<?php

namespace WebPlatform\MediaWiki\Transformer\Tests\Model;

use WebPlatform\MediaWiki\Transformer\Model\Rule;

/**
 * Transformer Rule Test cases
 */
class RuleTest extends \PHPUnit_Framework_TestCase {

	protected $sample = '';

	public function setUp() {
		$this->sample = <<<SAMPLE
= With spaces =
SAMPLE;
	}

	/**
	 * @covers \WebPlatform\MediaWiki\Transformer\Model\Rule::execute
	 * @expectedException \WebPlatform\MediaWiki\Transformer\Model\UnsupportedInputException
	 */
	public function testInvalidInput() {
		$replace = '# ${1}';
		$rules[] = '/^=(.*)=$/';

		$rule = new Rule($rules, $replace);

		// Should return an exception, no need to go further
		$rule->execute(null);
	}

	/**
	 * @covers \WebPlatform\MediaWiki\Transformer\Model\Rule::execute
	 */
	public function testExecuteReturnType() {
		$replace = '# ${1}';
		$rules[] = '/^=(.*)=$/';

		$rule = new Rule($rules, $replace);

		$output = $rule->execute($this->sample);

		$this->assertEquals(is_string($output), true);
	}

	/**
	 * @covers \WebPlatform\MediaWiki\Transformer\Model\Rule::__construct
	 * @expectedException \WebPlatform\MediaWiki\Transformer\Model\UnsupportedReplacementException
	 */
	public function testInvalidConstructorArg0() {
		$replace = new \stdClass;
		$rules[] = '/^=(.*)=$/';

		// Should return an exception, no need to go further
		$rule = new Rule($rules, $replace);
	}

	/**
	 * @covers \WebPlatform\MediaWiki\Transformer\Model\Rule::__construct
	 * @expectedException \WebPlatform\MediaWiki\Transformer\Model\ReplacementMarkerMissingException
	 */
	public function testInvalidConstructorArg1() {
		$replace = 'I am a bogus string with missing preg_replace placeholder';
		$rules[] = '/^=(.*)=$/';

		// Should return an exception, no need to go further
		$rule = new Rule($rules, $replace);
	}

}