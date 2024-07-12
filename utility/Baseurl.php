<?php 
class Baseurl{

  public function url(){
    return sprintf(
      "%s://%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME'],
    );
  }

  public function reqUri(){
    return sprintf(
      "%s",
      $_SERVER['REQUEST_URI']
    );
  }
}
