<?php

  /*
   * CodeDesign
   * deploying easily styles and javascript files in php environment.
   * 
   * @author idanm
  */

  // Setting File 
  define("ENV_FILE_PATH", __DIR__ . "/../environment.json");

  // Environment check and level
  require_once(__DIR__ . '/environment-mount.php');

  // System Files
  require_once(__DIR__ . '/interface.php');
  require_once(__DIR__ . '/library.php');
  require_once(__DIR__ . '/file.php');
  require_once(__DIR__ . '/maintenance.php');
  require_once(__DIR__ . '/run.php');

  // Work Igor!!!
  Code::Run();

?> 