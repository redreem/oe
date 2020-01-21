<?php

class E_Logger extends E_Base {

  public $type = 'static';

  static $logEventNames = array(

    'doConstructor' => '<b style="color:#8ab">do constructor: </b>',
    'doExecute' => '<b style="color:#44f">do execute: </b>',
    'tryExecute' => '<b style="color:#ff4">try execute: </b>',
    'passMethod' => '<b style="color:#f44">pass method: </b>',
    'passConstructor' => '<b style="color:#f44">pass constructor: </b>',

  );

  static $identS = '<span style="color:#aad">';
  static $identE = '</span>';

  public function prepare_before() {

    $console = new E_Console;

  }

  static public function logger($eventAlias, $className, $method='<UNKNOWN>', $param = '<NO PARAM>') {

    $currentLog = self::$logEventNames[ $eventAlias ] . self::$identS . $method . self::$identE . ' <b>(</b>' . $param . '<b>) IN</b> ' . self::$identS . $className . self::$identE;
    E_Console::add_data($currentLog);

  }

}