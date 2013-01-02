<?php
  
  // Client Class
  class Code {
    public static function Stylesheet(array $list = null, $cache = false, $minify = false, $concat = false) {
      echo (new File('stylesheet', $list, $cache, $minify, $concat));
    }
    public static function Javascript(array $list = null, $cache = false, $minify = false, $concat = false) {
      echo (new File('javascript', $list, $cache, $minify, $concat));
    }
    public static function Content() {
      echo "content";
    }
  }

?> 