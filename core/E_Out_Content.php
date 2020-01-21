<?php

class E_Out_Content extends E_Base {// вывод

  public $type = 'static';

  public function execute() {

    E_Console::close_data();

    header('Content-type: text/html; charset=utf-8');

    echo self::$enviroment->currentEventResult;

    if ( (E_Config_Mandatory::$data['console']) OR (E_Config_Mandatory::$data['log']) ) {

      echo E_Console::$data;

    }

  }

}