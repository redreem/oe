<?php

class E_Controller_login extends E_View_Controller {

  protected $tplName = ''; // страница входа имеет 2 представления, для гостя и для пользователя
  protected $tplNameGuest = 'login/login_guest';
  protected $tplNameUser = 'login/login_user';

  public function prepare_before() {

    if (E_Service::check_logged()) {
      $this->tplName = $this->tplNameUser;
    } else {
      $this->tplName = $this->tplNameGuest;
    }

  }

}