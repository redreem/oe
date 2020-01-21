<?php

class E_View_Controller extends E_Base { //базовый класс контроллеров представления

  protected $tplName = false;
  protected $tpl = '';
  protected $find =  array ();
  protected $replace = array ();

  public final function prepare_after() {

    if ($this->tplName === false) $this->tplName = self::$enviroment->currentEventParam; // берем алиас

  }

  public final function data_set($name, $value) {

    $this->find[] = $name;
    $this->replace[] = $value;

  }

  public final function clear() {

    $this->find = array ();
    $this->replace = array ();
    $this->tpl = null;

  }

  public final function render() {

    $this->tplName = TEMPLATE_DIR_ABS . '/' . E_Config_Mandatory::$data['view']['template'] . '/tpl/' . $this->tplName . '.tpl'; // формируем путь + имя шаблона

    $this->tpl = file_get_contents( $this->tplName );

    if (count($this->find) != 0) {

      $this->result = str_replace($this->find, $this->replace, $this->tpl);

    } else {

      $this->result = &$this->tpl;

    }

    self::$enviroment->currentEventResult = $this->result;

  }

  public function execute() {

    $this->render();

  }

}