<?php
App::uses('Dotcake', 'Dotcake.Lib');

/**
 * DotcakeTestCase file
 *
 * @copyright     Copyright (c) dorcake organization. (http://github.com/dotcake)
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
class DotcakeTestCase extends CakeTestCase {

	/**
	 * setUp
	 *
	 */
	public function setUp(){
		App::build(array(), App::REGISTER);
	}

	/**
	 * tearDown
	 *
	 */
	public function tearDown(){
		unset($this->Dotcake);
		App::build(array(), App::REGISTER);
	}

	/**
	 * test_simpleGenerate
	 *
	 */
	public function test_simpleGenerate(){
		$this->Dotcake = new Dotcake();
		$result = $this->Dotcake->generate();
		$this->assertTrue(array_key_exists('cake', $result));
		$this->assertTrue(array_key_exists('build_path', $result));
		$this->assertEqual(realpath(APP . $result['cake']), realpath(CAKE_CORE_INCLUDE_PATH));
		$this->assertEqual(count($result['build_path']), 18);

		$this->assertTrue(in_array('./Model/', $result['build_path']['models']));
		$this->assertTrue(in_array('./Model/Behavior/', $result['build_path']['behaviors']));
		$this->assertTrue(in_array('./Model/Datasource/', $result['build_path']['datasources']));
		$this->assertTrue(in_array('./Model/Datasource/Database/', $result['build_path']['databases']));
		$this->assertTrue(in_array('./Model/Datasource/Session/', $result['build_path']['sessions']));
		$this->assertTrue(in_array('./Controller/', $result['build_path']['controllers']));
		$this->assertTrue(in_array('./Controller/Component/', $result['build_path']['components']));
		$this->assertTrue(in_array('./Controller/Component/Auth/', $result['build_path']['auths']));
		$this->assertTrue(in_array('./Controller/Component/Acl/', $result['build_path']['acls']));
		$this->assertTrue(in_array('./View/', $result['build_path']['views']));
		$this->assertTrue(in_array('./View/Helper/', $result['build_path']['helpers']));
		$this->assertTrue(in_array('./Console/', $result['build_path']['consoles']));
		$this->assertTrue(in_array('./Console/Command/', $result['build_path']['commands']));
		$this->assertTrue(in_array('./Console/Command/Task/', $result['build_path']['tasks']));
		$this->assertTrue(in_array('./Lib/', $result['build_path']['libs']));
		$this->assertTrue(in_array('./Locale/', $result['build_path']['locales']));
		$this->assertTrue(in_array('./Vendor/', $result['build_path']['vendors']));
		$this->assertTrue(in_array('./Plugin/', $result['build_path']['plugins']));
	}

	/**
	 * test_RelativePath
	 * jpn: '/'からはじまらないパスはそのまま相対パスとして処理する
	 *
	 * @param
	 */
	public function test_RelativePath(){
		App::build(array(
			'Plugin' => array('path/to/plugins/')
		));
		$this->Dotcake = new Dotcake();
		$result = $this->Dotcake->generate();
		$this->assertTrue(in_array('path/to/plugins/', $result['build_path']['plugins']));
	}

	/**
	 * test_PathPriority
	 * jpn: App::build()で後から追加されたパスが優先される
	 *
	 */
	public function test_PathPriority(){
		App::build(array(
			'Plugin' => array('first/path/to/plugins/', 'second/path/to/plugins/')
		));
		App::build(array(
			'Plugin' => array('third/path/to/plugins/')
		));
		$this->Dotcake = new Dotcake();
		$result = $this->Dotcake->generate();
		$this->assertEqual($result['build_path']['plugins'][0], 'third/path/to/plugins/');
		$this->assertEqual($result['build_path']['plugins'][1], 'first/path/to/plugins/');
		$this->assertEqual($result['build_path']['plugins'][2], 'second/path/to/plugins/');
		$this->assertEqual($result['build_path']['plugins'][3], './Plugin/');
	}
}
