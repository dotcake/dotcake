<?php

/**
 * Formatter class
 *
 * @copyright     Copyright (c) dotcake organization. (https://github.com/dotcake)
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Formatter {

	private $__indentString;

	private $__indentCount = 0;

	private $__isInQuotes = false;

	public function __construct($indentString = "\t") {
		$this->__indentString = $indentString;
	}

/**
 * Reformat return value of json_encode().
 * Note: If a text contains whitespace, tab, e.t.c.,
 * this method will return broken format.
 *
 * @param string $text
 */
	public function reformat($text) {
		$formattedText = "";
		$strlen = strlen($text);
		for ($i = 0; $i < $strlen; $i++) {
			// only single byte
			$char = $text[$i];
			switch ($char) {
				case '{': // no break
				case '[':
					$this->__increaseIndentCount();
					$formattedText .= $char . $this->__getNewLine() . $this->__getIndent();
					break;
				case '}': // no break
				case ']':
					$this->__decreaseIndentCount();
					$formattedText .= $this->__getNewLine() . $this->__getIndent() . $char;
					break;
				case ',':
					$formattedText .= $char . $this->__getNewLine() . $this->__getIndent();
					break;
				case '"':
					$this->__isInQuotes = !$this->__isInQuotes;
					$formattedText .= $char;
					break;
				case '\\':
					$formattedText .= $char . $text[++$i];
					break;
				default:
					$formattedText .= $char;
					break;
			}
		}
		return $formattedText;
	}

/**
 * Get new line
 *
 * @return string New line if it's not in quotes, otherwise empty string.
 */
	private function __getNewLine() {
		return $this->__isInQuotes ? "" : "\n";
	}

/**
 * Get indent
 *
 * @return string Empty string if indent count is 0 or it's in quotes, otherwise indent space.
 */
	private function __getIndent() {
		return $this->__isInQuotes ? "" : str_repeat($this->__indentString, $this->__indentCount);
	}

/**
 * Increase indent count
 *
 */
	private function __increaseIndentCount() {
		if (!$this->__isInQuotes) {
			$this->__indentCount++;
		}
	}

/**
 * Decrease indent count
 *
 */
	private function __decreaseIndentCount() {
		if (!$this->__isInQuotes) {
			$this->__indentCount--;
		}
	}

}
