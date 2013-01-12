<?php
  
  require_once('codedesign/init.php');

  class ClientCodeTest extends PHPUnit_Framework_TestCase {
    public static $outputStrings = array();

    protected function setUp() {
      static::$outputStrings['stylesheetTagMin'] = '<link rel="stylesheet" type="text/css" href="style/common.min.css" media="screen">';
      static::$outputStrings['javascriptTagMin'] = '<script src="script/common.min.js"></script>';
    }

    public function testStylesheet() {
      Stylesheet();
      $this->expectOutputString(static::$outputStrings['stylesheetTagMin']);
    }

    public function testJavascript() {      
      Javascript();
      $this->expectOutputString(static::$outputStrings['javascriptTagMin']);
    }

    public function testContent() {
      Content();
      $this->expectOutputString('content');
    }
  }
?>