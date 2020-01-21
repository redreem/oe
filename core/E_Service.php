<?php

class E_Service extends E_Base { // статичное событие - просто набор всяких сервисных функций

  public $type = 'static';

  static $domainCookie = null;
  static $domainCookieCount = null;
  static $domainAllowCount = -2;


  public final function execute() {

    self::$domainCookie = explode (".", self::clean_url( $_SERVER['HTTP_HOST'] ));
    self::$domainCookieCount = count(self::$domainCookie);
    self::$domainAllowCount = -2;

    if ( self::$domainCookieCount > 2 ) {

      if ( in_array(self::$domainCookie[self::$domainCookieCount-2], array('com', 'net', 'org') )) self::$domainAllowCount = -3;
      if ( self::$domainCookie[self::$domainCookieCount-1] == 'ua' ) self::$domainAllowCount = -3;
      self::$domainCookie = array_slice(self::$domainCookie, self::$domainAllowCount);
    }

    self::$domainCookie = "." . implode (".", self::$domainCookie);

    if ((ip2long($_SERVER['HTTP_HOST']) != -1) AND (ip2long($_SERVER['HTTP_HOST']) !== false )) {
      define( 'DOMAIN', null );
    } else {
      define( 'DOMAIN', self::$domainCookie );
    }

  }

  static final function clean_url($urlUTF) {

    $url = strtolower( iconv('utf-8', 'cp1251', $urlUTF) );

    if( $url == '' ) return;

    $url = str_replace( "http://", "", $url );
    $url = str_replace( "https://", "", $url );

    if( substr( $url, 0, 4 ) == 'www.' ) $url = substr( $url, 4 );

    $url = explode( '/', $url );
    $url = reset( $url );
    $url = explode( ':', $url );
    $url = reset( $url );

    return iconv('cp1251', 'utf-8', $url);

  }

  static final function set_cookie($name, $value = '', $expires = 0) {

    $_COOKIE[$name] = $value;

    if ($_SERVER['HTTP_HOST'] == 'localhost') {

      setcookie( $name, $value, $expires, '/' );

    } else {

      setcookie( $name, $value, $expires, '/', DOMAIN , 0 );

    }

  }

  static final function check_logged() {

    if (isset($_COOKIE['logged'])) {

      if ($_COOKIE['logged'] == 1) return true;

    }

    return false;

  }

}