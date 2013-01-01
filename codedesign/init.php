<?php

  /*
   * CodeDesign
   * deploying easily styles and javascript files in php environment.
   * 
   * @author idanm
  */

  define("BASE_URL", __DIR__ . '/');

  // Environment check and level
  require_once(BASE_URL . 'environment-mount.php');

  // Configurations
  // require_once(BASE_URL . 'config.php');

  // Stylesheet and Javascript tag and file creation
  require_once(BASE_URL . 'file.php');

  // Client file
  require_once(BASE_URL . 'code.php');

?> 