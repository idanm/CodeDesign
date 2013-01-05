<?php

  /*
   * CodeDesign
   * deploying easily styles and javascript files in php environment.
   * 
   * @author idanm
  */

  define('BASE_URL', __DIR__ . '/');
  define('LIBRARY', BASE_URL . 'libs/');
  define('ENV_FILE', BASE_URL . 'environment.json');

  require_once(BASE_URL . 'environment-mount.php');
  require_once(BASE_URL . 'maintenance.php');
  require_once(BASE_URL . 'config.php');
  require_once(BASE_URL . 'library.php');
  require_once(BASE_URL . 'file.php');
  require_once(BASE_URL . 'client.code.php');

  Config::Set(ENV_FILE, $_SERVER['SERVER_NAME']);

?> 