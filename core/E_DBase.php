<?php

class E_DBase extends E_Base { // будет класс события работы с бзой, пока заглушка - чисто для авторизации

  static $dBase = false;

  public $type = 'static';

  static final function connect() {

  }

  static final function get_row() {

    if (!self::$dBase) return false;
    return array('login' => 'admin', 'password' => 'admin' );

  }

  public final function execute() {

    self::$dBase = true;

  }

}