<?php

class E_Config_Mandatory extends E_Base {

  public $type = 'static';

  static $data = array (

    'charset' => 'utf-8',

    'console' => true,
    //'console' => false,

    'log' => true,
    //'log' => false,

    'eventAliases' => array ( //алиасы и имена классов события

      'LOGIN' => 'E_Controller_doLogin',
      'LOGOUT' => 'E_Controller_doLogout',

      'common' => 'E_Controller_common',
      'main' => 'E_Controller_main',
      'about' => 'E_Controller_about',
      'login' => 'E_Controller_login',
      'logout' => 'E_Controller_logout',
      'menu' => 'E_Controller_menu',

    ),

    'view' => array (

      'defaultPage' => 'main',
      'currentPage' => 'main',
      'template' => 'default',

    ),

  );

  public final function prepare_before () {

    ini_set('include_path',
      ROOT_DIR . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR .
      PATH_SEPARATOR . ROOT_DIR . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR .
      PATH_SEPARATOR . ROOT_DIR . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR
    );

    date_default_timezone_set('Europe/Moscow');

    define ('CORE_DIR_ABS', ROOT_DIR . '/core');
    define ('TEMPLATE_DIR_ABS', ROOT_DIR . '/template');
    define ('TEMPLATE_DIR_REL', '/template');

    if ($_SERVER['HTTP_HOST'] == 'localhost') {

      self::$data['http_home_url'] = 'http://localhost';

    } else {

      self::$data['http_home_url'] = '';

    }

    if (self::$data['log']) {

      $logger = new E_Logger();

    } elseif (self::$data['console']) { // логгер и так подгрузит консоль, если будет вызван, поэтому консоль подгружается принудительно только если логгер не был вызван

      $console = new E_Console();

    }



  }

  public final function prepare_after () {

    self::$enviroment = new E_Enviroment;

  }

}