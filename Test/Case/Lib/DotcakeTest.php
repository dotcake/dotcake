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

    $this->assertEqual($result['build_path']['models'][0], './Model/');
    $this->assertEqual($result['build_path']['behaviors'][0], './Model/Behavior/');
    $this->assertEqual($result['build_path']['datasources'][0], './Model/Datasource/');
    $this->assertEqual($result['build_path']['databases'][0], './Model/Datasource/Database/');
    $this->assertEqual($result['build_path']['sessions'][0], './Model/Datasource/Session/');
    $this->assertEqual($result['build_path']['controllers'][0], './Controller/');
    $this->assertEqual($result['build_path']['components'][0], './Controller/Component/');
    $this->assertEqual($result['build_path']['auths'][0], './Controller/Component/Auth/');
    $this->assertEqual($result['build_path']['acls'][0], './Controller/Component/Acl/');
    $this->assertEqual($result['build_path']['views'][0], './View/');
    $this->assertEqual($result['build_path']['helpers'][0], './View/Helper/');
    $this->assertEqual($result['build_path']['consoles'][0], './Console/');
    $this->assertEqual($result['build_path']['commands'][0], './Console/Command/');
    $this->assertEqual($result['build_path']['tasks'][0], './Console/Command/Task/');
    $this->assertEqual($result['build_path']['libs'][0], './Lib/');
    $this->assertEqual($result['build_path']['locales'][0], './Locale/');
    $this->assertEqual($result['build_path']['vendors'][0], './Vendor/');
    $this->assertEqual($result['build_path']['plugins'][0], './Plugin/');
  }
}
