<?php

declare(strict_types=1);

namespace Endermanbugzjfc\JunkBay\Extract;

use PHPUnit\Framework\TestCase;

class ExtracterTest extends TestCase {

	public function testGroupSubCommands() : void {
		$subCommands = Extracter::groupSubCommands(
			"bbbbb",
			"dog",
			"cat",
			"catdog",
			"catdogbbbbb",
			"aaa",
			"aaaa"
		);

		$this->assertSame([
			"dog" => [],
			"cat" => ["dog", "dogbbbbb"], // "catdog", "catdogbbbbb".
			"aaa" => ["a"], // "aaaa".
			"bbbbb" => [],
		], $subCommands);
	}
}