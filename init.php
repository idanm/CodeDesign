<?php

  /*
   * CodeDesign
   * deploying easily styles and javascript files in php environment.
   * 
   * @author idanm
  */

  define('BASE_URL', __DIR__ . '/../');
  define('APP', BASE_URL . 'codedesign/');
  define('LIBRARY', APP . 'libs/');
  define('ENV_FILE', APP . 'environment.yaml');

  require_once(APP . 'environment-mount.php');
  require_once(APP . 'maintenance.php');
  require_once(APP . 'config.php');
  require_once(APP . 'library.php');
  require_once(APP . 'file.php');
  require_once(APP . 'client.php');

var_dump(ENV_FILE);

  // Config::Set(ENV_FILE, 'development');

?> 