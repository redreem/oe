<?php

class E_Enviroment extends E_Base {

  public $type = 'static';

  public $urlPath = array();

  public $currentEventResult; // некий текущий результат. используется в контексте исполнения цепочки.
  public $currentEventParam; // некие текущие параметры. используются в контексте исполнения цепочки.

  public $currentPageContoller = true;

  public final function prepare_before() {

    if ( isset($_GET['urlpath']) ) {

      $this->urlPath = explode( '/', $_GET['urlpath'] );

    } else {

      $this->urlPath[0] = '';

    }

  }
}