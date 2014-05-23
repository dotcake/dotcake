<?php

App::uses('Formatter', 'Dotcake.Lib');

/**
 * FormatterTestCase file
 *
 * @copyright     Copyright (c) dotcake organization. (https://github.com/dotcake)
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
class FormatterTestCase extends CakeTestCase {

/**
 * setUp
 *
 */
	public function setUp() {
	}

/**
 * tearDown
 *
 */
	public function tearDown() {
		unset($this->Formatter);
	}

/**
 * testReformat
 *
 */
	public function testReformat() {
		$this->Formatter = new Formatter();
		$text = <<< EOD
{"cake":"..\/lib\/","build_path":{"models":[".\/Model\/"],"behaviors":[".\/Model\/Behavior\/",".\/MyModel\/Behavior\/"]}}
EOD;
		$result = $this->Formatter->reformat($text);
		$expected = <<< EOD
{
	"cake":"..\/lib\/",
	"build_path":{
		"models":[
			".\/Model\/"
		],
		"behaviors":[
			".\/Model\/Behavior\/",
			".\/MyModel\/Behavior\/"
		]
	}
}
EOD;
		$this->assertEquals($expected, $result);
	}

/**
 * testReformatWithWhitespace
 *
 */
	public function testReformatWithWhitespace() {
		$this->Formatter = new Formatter("    ");
		$text = <<< EOD
{"cake":"..\/lib\/","build_path":{"models":[".\/Model\/"],"behaviors":[".\/Model\/Behavior\/",".\/MyModel\/Behavior\/"]}}
EOD;
		$result = $this->Formatter->reformat($text);
		$expected = <<< EOD
{
    "cake":"..\/lib\/",
    "build_path":{
        "models":[
            ".\/Model\/"
        ],
        "behaviors":[
            ".\/Model\/Behavior\/",
            ".\/MyModel\/Behavior\/"
        ]
    }
}
EOD;
		$this->assertEquals($expected, $result);
	}

/**
 * testReformatQuotedBracesAndComma
 *
 */
	public function testReformatQuotedBracesAndComma() {
		$this->Formatter = new Formatter();
		$text = <<< EOD
{"cake":"}","build_path":{"models":[",["]}}
EOD;
		$result = $this->Formatter->reformat($text);
		$expected = <<< EOD
{
	"cake":"}",
	"build_path":{
		"models":[
			",["
		]
	}
}
EOD;
		$this->assertEquals($expected, $result);
	}

}
