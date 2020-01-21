<?php

class E_Manager extends E_Base { // менеджер событий

  public $type = 'static';

  static private $requestEventAlias; // алиас события от клиента

  static function parse_request_event() { // принимаем решение о событии, согласно запросу клиента


    if (isset($_REQUEST['event'])) { // если алиас события указано явно в гет или пост

      self::$requestEventAlias = $_REQUEST['event'];

      if (isset(E_Config_Mandatory::$data['eventAliases'][ self::$requestEventAlias ])) { // если алиас прописан в реестре событий

        $eventClassName = E_Config_Mandatory::$data['eventAliases'][ self::$requestEventAlias ]; // берем название класса события по алиасу

        return $eventClassName;

      }

    }

    if ( self::$enviroment->urlPath[0] != '' ) { //если в URL возможно есть алиас представления, забираем его

      E_Config_Mandatory::$data['view']['currentPage'] = self::$enviroment->urlPath[0];

      if ( !isset( E_Config_Mandatory::$data['eventAliases'][ self::$enviroment->urlPath[0] ] ) ) {

        // попытаемся проверить, нет ли tpl без контроллера. если есть, то берем ее. этот момент тестовый. может быть убран далее, если окажется невостребованным.
        if ( file_exists( TEMPLATE_DIR_ABS . '/' . E_Config_Mandatory::$data['view']['template'] . '/tpl/' . self::$enviroment->urlPath[0]  . '.tpl' ) ) {

          self::$enviroment->currentPageContoller = false;

        } else {

          E_Config_Mandatory::$data['view']['currentPage'] = 'page404';

        }

      }

    } else { //иначе берем "по умолчанию"

      E_Config_Mandatory::$data['view']['currentPage'] = E_Config_Mandatory::$data['view']['defaultPage'];

    }

    if (!isset($_REQUEST['ajax'])) {  //если представление не было запрошено аджаксом, то инициализируем формирование представления полного макета страницы

      self::$enviroment->currentEventParam = 'common';

    } else {

      self::$enviroment->currentEventParam = E_Config_Mandatory::$data['view']['currentPage'];

      if (!self::$enviroment->currentPageContoller) {

        return 'E_View_Controller';

      }

    }

    return 'E_Controller_' . self::$enviroment->currentEventParam . '';

  }

  static protected function execute_chain() {

    $event = self::$refFirstEvent;

    while ( $event != null ) {

      if (E_Config_Mandatory::$data['log']) {
        E_Logger::logger('tryExecute', get_class($event) );
      }

      if (!$event->executed) $event->execute();

      $event = $event->refEventAfter;

    }

  }


  public function execute() {

    $this->executed = true;

    $config = new E_Config_Mandatory(); // подрубаем конфиг, это некий конфиг, нужный всегда. дальше будут еще конфиги, которые будут подрубаться уже в зависимости от событий

    $requestEventName = self::parse_request_event();

    $requestEvent = new $requestEventName;

    $out = new E_Out_Content(); // вывод данных клиенту

    self::execute_chain(); // компилируем очередь событий

  }

}