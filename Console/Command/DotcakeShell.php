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
      break;
    default:
      $this->out(__d('cake_console', 'You have made an invalid selection. Please choose a command to execute by entering M or Q.'));
    }
    $this->hr();
    $this->main();
  }

  /**
   * generate
   *
   * @param
   */
  public function generate(){
    $this->out('Generate .cake ...');
    $d = new Dotcake(APP, App::paths(), CAKE_CORE_INCLUDE_PATH);
    $this->createFile(APP . '.cake', json_encode($d->generate()));
  }

  /**
   * help
   *
   */
  public function help() {
    $this->out(__d('cake_console', 'CakePHP .cake Generator'));
    $this->hr();
    $this->out(__d('cake_console',"Usage: cake Dotcake.dotcake generate"));
    $this->hr();
    $this->out("");
  }
}
