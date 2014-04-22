<?php
App::uses('Dotcake', 'Dotcake.Lib');

class DotcakeTestCase extends CakeTestCase {

  /**
   * setUp
   *
   */
  public function setUp(){
  }

  /**
   * tearDown
   *
   */
  public function tearDown(){
    unset($this->Dotcake);
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
}
