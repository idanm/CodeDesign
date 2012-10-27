<?php

  /*
   * CodeDesign
   * deploying easily styles and javascript files in php environment.
   * 
   * @author idanm
  */

  // Environment check and level
  require_once(dirname(__FILE__) . '/environment-mount.php');

  // System Files
  require_once(dirname(__FILE__) . '/interface.php');
  require_once(dirname(__FILE__) . '/library.php');
  require_once(dirname(__FILE__) . '/file.php');
  require_once(dirname(__FILE__) . '/maintenance.php');
  require_once(dirname(__FILE__) . '/run.php');

  // Work Igor!!!
  Code::Run();

?> 