<?php

class E_Controller_doLogout extends E_Base {

  public function prepare_after() {

    E_Service::set_cookie( 'logged', '0', 0);

    //после выхода - формируем представление для главной страницы и отправляем его юзеру

    E_Config_Mandatory::$data['view']['currentPage'] = 'main';

    $common = new E_Controller_common;

  }


}