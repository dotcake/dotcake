<?php
App::uses('Infrector', 'Utility');

/**
 * Dotcake class
 *
 * @copyright     Copyright (c) dotcake organization. (https://github.com/dotcake)
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Dotcake {

	private $base;
	private $cake;
	private $paths;

	/**
	 * __construct
	 *
	 * @param string $base
	 * @param array $paths
	 * @param string $cake
	 * @return
	 */
	public function __construct($base = null, array $paths = array(), $cake = null){
		if ($base === null) {
			$base = APP;
		}
		$this->base = $base;
		if ($paths === array()) {
			$paths = App::paths();
		}
		$this->paths = $paths;
		if ($cake === null) {
			$cake = CAKE_CORE_INCLUDE_PATH;
		}
		$this->cake = $this->relativePath($cake);
	}

	/**
	 * generate
	 * Generate .cake array
	 *
	 * @return array $dotcake
	 */
	public function generate(){
		$dotcake = array();
		$dotcake['cake'] = $this->cake;
		$dotcake['build_path'] = array();
		$paths = $this->paths;
		foreach ($paths as $key => $values) {
			$formatted_key = strtolower(Inflector::pluralize(preg_replace('/\A.+\//', '', $key)));
			$dotcake['build_path'][$formatted_key] = array();
			$dotcake['build_path'][$formatted_key] = array_map(array($this, 'relativePath'), $values);
		}
		return $dotcake;
	}

	/**
	 * relativePath
	 * build relative filepath
	 *
	 * @param string $target
	 * @return string $relativePathString
	 */
	public function relativePath($target) {
		$base = $this->base;
		$base = rtrim($base, '\/') . '/';
		$target = rtrim($target, '\/') . '/';

		if (substr($target, 0, 1) !== '/') {
			return $target;
		}

		$base = explode('/', $base);
		$target = explode('/', $target);
		$relativePath = $target;

		foreach($base as $depth => $dir) {
			if($target[$depth] === $dir) {
				array_shift($relativePath);
			} else {
				$remaining = count($base) - $depth;
				if($remaining > 1) {
					$padLength = (count($relativePath) + $remaining - 1) * -1;
					$relativePath = array_pad($relativePath, $padLength, '..');
					break;
				} else {
					$relativePath[0] = './' . $relativePath[0];
				}
			}
		}
		return implode('/', $relativePath);
	}
}
