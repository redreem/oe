<?php

class E_Console extends E_Base { //консоль.

  public $type = 'static';

  static private $count = 0;

  static public $data = '';
  static public $errorHandler = false;

  static private $zebraBgColors = array ( 0 => '#222', 1 => '#333');

  static $zebraBgColorIndex = 0;

  static public $startTime = false;

  static public function add_data($data) {

    if (self::$count==0) {

      E_Console::$data .= '<div onclick="if (this.style.zIndex == 20000) this.style.zIndex = 0; else this.style.zIndex = 20000;" class="console">';
      E_Console::$data .= '<div class="muar">Octopus Events Console</div>';

    }

    self::$count++;
    E_Console::$data .= '<div class="item" style="background:' . self::$zebraBgColors[ self::$zebraBgColorIndex ] . '">';
    E_Console::$data .= '<span class="count">'. self::$count . ':</span> ';

    if ( gettype($data) != 'string' ) $data .= var_export($data, true);

    E_Console::$data .= $data . '</div>';

    self::$zebraBgColorIndex = 1 - self::$zebraBgColorIndex;

  }

  static public function close_data() {

    if (self::$count > 0) self::$data .= '</div>';

  }

  static public function timer_start() {

    $mtime = microtime();
    $mtime = explode( ' ', $mtime );
    $mtime = $mtime[1] + $mtime[0];

    self::$startTime = $mtime;
  }

  static public function timer_stop() {

    $mtime = microtime();
    $mtime = explode( ' ', $mtime );
    $mtime = $mtime[1] + $mtime[0];

    $totaltime = round( ($mtime - self::$startTime), 5 );

    return $totaltime;

  }

  static public function error_trigger($errNo, $errStr, $errFile, $errLine, $context) {

    E_Console::add_data('<b>Error:</b> '.$errNo.'<b> | File: </b>'.$errFile.'<b> | Line: </b>'.$errLine.'<br>'.$errStr);

  }

  public function prepare_before() {

    error_reporting(E_ALL);

    self::$errorHandler = set_error_handler('E_Console::error_trigger');
    self::timer_start();

  }

}