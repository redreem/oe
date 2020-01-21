<?php

abstract class E_Base { //базовый класс для событий

  //индивидуальные параметры экземпляров событий

  public $type = 'dynamic'; //dynamic, static - тип события
  public $executed = false; //выполнено ли событие
  public $refEventBefore = null; // ссылка на предыдущее событие в цепочке
  public $refEventAfter = null; // ссылка на следующее событие в цепочке
  public $result; // результат исполнения события

  // статические параметры класса

  static $refFirstEvent = null; // ссылка на текущее первое событие цепочки
  static $refLastEvent = null; // ссылка на текущее последнее событие цепочки
  static $eventsStatic = array (); // имена уже классов статичных событий, попадающих в цепочку - для контроля дублирования
  static $enviroment; // среда исполения. ссылка на экземпляр класса E_Enviroment.

  public final function __construct($refEventBefore = null) { // $refEventBefore - место в цепочке, если нужно поставить событие не в конце

    $currentClassName = get_class($this); // имя класса, в котором вызван конструктор

    if ( isset( self::$eventsStatic[ $currentClassName ] )) {

      if (E_Config_Mandatory::$data['log']) {// логирование отмены исполнения конструктора
        E_Logger::logger('passConstructor', $currentClassName, '');
      }
      unset($this); // если класс уже списке статичных

    }

    if (E_Config_Mandatory::$data['log']) {// логирование вызова конструктора
      E_Logger::logger('doConstructor', $currentClassName, '');
    }


    $this->prepare_before(); // исполняем то, что должно быть отработано перед постановкой события в очередь. как правило тут сидят вызовы конструкторов других событий

    if ($refEventBefore === null) { // цепляем событие к цепочке после последнего события

      if (self::$refLastEvent === null) {

        self::$refFirstEvent = $this;

      } else {

        self::$refLastEvent->refEventAfter = $this;

      }

      $this->refEventBefore = self::$refLastEvent;

      self::$refLastEvent = $this;

    } else { // вставляем событие не в конец цепочки

      $this->refEventBefore = $refEventBefore;

      $this->refEventAfter = $refEventBefore->refEventAfter;

    }

    if ($this->type == 'static') { // если событие статическое - учитываем факт его инициализации

      self::$eventsStatic[ $currentClassName ] = true;

    }

    $this->prepare_after(); // исполняем то, что должно быть отработано после постановки события в очередь, но до компиляции событя. как правило тут инициализации некоторых параметров в контексте события.


  }

  public function execute() {

    self::$enviroment->currentEventResult = $this->result;

  }

  public function prepare_before() {
  }

  public function prepare_after() {
  }

  public final function __call($method, $param) { // чисто для логгера. логгер вызова несуществующих у экземпляра методов
    if (E_Config_Mandatory::$data['log']) {
      E_Logger::logger('passMethod', get_class($this), $method, $param);
    }

  }

}