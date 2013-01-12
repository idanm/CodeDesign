<?php
  
  require_once('codedesign/init.php');

  class ClientCodeTest extends PHPUnit_Framework_TestCase {
    public static $outputStrings = array();

    protected function setUp() {
      static::$outputStrings['stylesheetTagConcat'] = '<link rel="stylesheet" type="text/css" href="style/common.css" media="screen">';
      static::$outputStrings['stylesheetTagMin'] = '<link rel="stylesheet" type="text/css" href="style/common.min.css" media="screen">';
      static::$outputStrings['javascriptTagConcat'] = '<script src="script/common.js"></script>';
      static::$outputStrings['javascriptTagMin'] = '<script src="script/common.min.js"></script>';
    }

    public function testStylesheet() {
      Code::Stylesheet();
      $this->expectOutputString(static::$outputStrings['stylesheetTagConcat']);

      Code::Stylesheet();
      $this->expectOutputString(static::$outputStrings['stylesheetTagMin']);
    }

    public function testJavascript() {
      Code::Javascript();
      $this->expectOutputString(static::$outputStrings['javascriptTagConcat']);
      
      Code::Javascript();
      $this->expectOutputString(static::$outputStrings['javascriptTagMin']);
    }

    public function testContent() {
      Code::Content();
      $this->expectOutputString('content');
    }
  }
?>