<?php
App::uses('Shell', 'Console');
App::uses('Dotcake', 'Dotcake.Lib');
App::uses('Formatter', 'Dotcake.Lib');

/**
 * DotcakeShell class
 *
 * @copyright     Copyright (c) dotcake organization. (https://github.com/dotcake)
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
class DotcakeShell extends Shell {

	public $tasks = array();

/**
 * startup
 *
 */
	public function startup() {
		parent::startup();
	}

/**
 * main
 *
 */
	public function main() {
		$this->out(__d('cake_console', 'CakePHP .cake Generator'));
		$this->hr();
		$this->out(__d('cake_console', '[G]enerate .cake'));
		$this->out(__d('cake_console', '[Q]uit'));

		$choice = strtoupper($this->in(__d('cake_console', 'What would you like to do?'), array('G', 'Q')));
		switch ($choice) {
			case 'G':
				$this->generate();
				break;
			case 'Q':
				exit(0);
			default:
				$this->out(__d('cake_console', 'You have made an invalid selection. Please choose a command to execute by entering M or Q.'));
		}
		$this->hr();
		$this->main();
	}

/**
 * generate
 *
 */
	public function generate() {
		$this->out('Generate .cake ...');
		$d = new Dotcake(APP, App::paths(), CAKE_CORE_INCLUDE_PATH);
		$contents = json_encode($d->generate());
		if (array_key_exists('format', $this->params)) {
			$format = $this->params['format'];
			switch ($format) {
				case 'tab':
					$formatter = new Formatter();
					$contents = $formatter->reformat($contents);
					break;
				case 'ws': // no break
				case 'whitespace':
					// can use JSON_PRETTY_PRINT option since PHP5.4
					$formatter = new Formatter('    '); // 4 spaces
					$contents = $formatter->reformat($contents);
					break;
				default:
					$this->out(__d('cake_console', "'{$format}' is invalid format option. You can use 'tab', 'ws' or 'whitespace' as option value."));
					exit(0);
			}
		}
		$this->createFile(APP . '.cake', $contents);
	}

/**
 * getOptionParser
 *
 */
	public function getOptionParser() {
		$parser = parent::getOptionParser();
		$parser->addOption('format', array(
			'help' => __d('cake_console', "Generate formatted json with tab or whitespace:'tab', 'ws' or 'whitespace'"),
		));
		return $parser;
	}

/**
 * help
 *
 */
	public function help() {
		$this->out(__d('cake_console', 'CakePHP .cake Generator'));
		$this->hr();
		$this->out(__d('cake_console', "Usage: cake Dotcake.dotcake generate"));
		$this->hr();
		$this->out("");
	}
}
