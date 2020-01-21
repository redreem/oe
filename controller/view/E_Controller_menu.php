<?php

class E_Controller_menu extends E_View_Controller {

  protected $tplName = 'menu/menu_guest'; // меню имеет 2 представления, для гостя и для пользователя.

  public function prepare_before() {

    if (E_Service::check_logged()) $this->tplName = 'menu/menu_user'; // ставим представление для пользователя если есть вход

  }

  public function execute() {

    // все что ниже - для подсветки в меню активной страницы
    $pageIndex = array (

      'main' => 1,
      'free' => 2,
      'about' => 3,
      'login' => 4

    );

    foreach ($pageIndex as $k => $v) {

      if ($k == E_Config_Mandatory::$data['view']['currentPage']) {

        $this->data_set('{active' . $v . '}', ' but_active');

      } else {

        $this->data_set('{active' . $v . '}', '');

      }

    }

    $this->render();

  }
}