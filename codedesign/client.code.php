<?php
  
  // Client Class
  class Code {
    public static function Stylesheet (
      array $list = array(),
      array $config = array()
    ) {
      echo (new File(
        Config::FileProperties('stylesheet', $list, $config)
      ));
    }
    
    public static function Javascript (
      array $list = array(),
      array $config = array()
    ) {
      echo (new File(
        Config::FileProperties('javascript', $list, $config)
      ));
    }

    public static function Content () {
      echo "content";
    }
  }

?> 