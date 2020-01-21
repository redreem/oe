<?php

class E_Controller_common extends E_View_Controller { // контроллер представления общего макета страниц

  protected $tplName = 'common';

  static private $menu; // экземпляр контроллера меню
  static private $footer; // экземпляр контроллера футера
  static private $content; // экземпляр контроллера контента текущей страницы

  static $pageTitles = array (// для title

    'main' => 'Главная',
    'about' => 'О проекте',
    'login' => 'Вход',
    'page404' => '404',
    'free' => 'FREE',

  );

  public function prepare_before() {

    self::$menu = new E_Controller_menu(); // ставим первоочередно событие формирования меню
    self::$footer = new E_Controller_footer(); // ставим первоочередно событие формирования футера

    if (self::$enviroment->currentPageContoller) {

      $contentControllerName = 'E_Controller_' . E_Config_Mandatory::$data['view']['currentPage'] . '';
      self::$content = new $contentControllerName; // ставим первоочередно событие формирования контента

    } else {

      $contentControllerName = 'E_View_Controller'; // котроллер для страницы без контроллера
      self::$content = new $contentControllerName;
      self::$content->tplName = E_Config_Mandatory::$data['view']['currentPage'];

    }

  }

  public function execute() {

    // задаем переменные шаблона

    $this->data_set('{metatags}', 'метатеги');
    $this->data_set('{TPL_DIR}', TEMPLATE_DIR_REL . '/default');
    $this->data_set('{TITLE}', self::$pageTitles[ E_Config_Mandatory::$data['view']['currentPage'] ]);

    $this->data_set('{content}', self::$content->result );
    $this->data_set('{menu}', self::$menu->result );
    $this->data_set('{footer}', self::$footer->result );

    $this->render();

  }

}