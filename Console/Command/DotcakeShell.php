<?php
App::uses('Shell', 'Console');
App::uses('Dotcake', 'Dotcake.Lib');

class DotcakeShell extends Shell {

  public $tasks = array();

  /**
   * startup
   *
   */
  public function startup(){
    parent::startup();
  }

  /**
   * main
   *
   */
  public function main() {
    $this->out('Generate .cake ...');
    $d = new Dotcake(APP, App::paths(), CAKE_CORE_INCLUDE_PATH);
    $this->createFile(APP . '.cake', json_encode($d->generate()));
  }

  /**
   * help
   *
   */
  public function help() {
    $this->out('CakePHP .cake Generator');
    $this->hr();
    $this->out("Usage: cake Dotcake.dotcake");
    $this->hr();
    $this->out("");
  }
}
