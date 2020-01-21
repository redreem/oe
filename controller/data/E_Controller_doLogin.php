<?php

class E_Controller_doLogin extends E_Base {


  public function prepare_before() {

    $dbase = new E_DBase();

  }
  public function execute() {

    $authArr = E_DBase::get_row(); // берем из базы данные

    if ( ($authArr['login'] == $_POST['login']) AND ($authArr['password'] == $_POST['password']) ) {

      E_Service::set_cookie( 'logged', '1', time() + 3600 );

      self::$enviroment->currentEventResult = 0; // результат успешной авторизации

    } else {

      E_Service::set_cookie( 'logged', '0', 0);

      self::$enviroment->currentEventResult = 1; // ошибка авторизации

    }

  }

}