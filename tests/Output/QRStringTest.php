<?php
/**
 * Class QRStringTest
 *
 * @filesource   QRStringTest.php
 * @created      24.12.2017
 * @package      chillerlan\QRCodeTest\Output
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\QRCodeTest\Output;

use chillerlan\QRCode\{QRCode, Output\QRString};

class QRStringTest extends QROutputTestAbstract{

	protected string $FQCN = QRString::class;

	public function types():array{
		return [
			'json' => [QRCode::OUTPUT_STRING_JSON],
			'text' => [QRCode::OUTPUT_STRING_TEXT],
		];
	}

	/**
	 * @dataProvider types
	 */
	public function testStringOutput(string $type):void{
		$this->options->outputType = $type;
		$this->options->cachefile  = $this::cachefile.$type;
		$this->setOutputInterface();
		$data = $this->outputInterface->dump();

		$this::assertSame($data, file_get_contents($this->options->cachefile));
	}

	public function testSetModuleValues():void{

		$this->options->moduleValues = [
			// data
			1024 => 'A',
			4    => 'B',
		];

		$this->setOutputInterface();
		$data = $this->outputInterface->dump();

		$this::assertStringContainsString('A', $data);
		$this::assertStringContainsString('B', $data);
	}

}
