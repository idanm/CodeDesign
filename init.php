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
  define('ENV_FILE', APP . 'environment.json');

  require_once(APP . 'environment-mount.php');
  require_once(APP . 'maintenance.php');
  require_once(APP . 'settings.php');
  require_once(APP . 'library.php');
  require_once(APP . 'file.php');
  require_once(APP . 'client.php');

  Settings::init( ENV_FILE );
  
?> 