<?php

  /*
   * A (simple) css minifier with benefits
   * URL https://github.com/brunschgi/cssmin
   * Coded By brunschgi (Remo Brunschwiler)
  */
  require_once(LIBRARY . 'cssmin/cssmin.php');
  
  /*
   * PHP port of Douglas Crockford's JSMin JavaScript minifier. (Maintained version)
   * URL https://github.com/eriknyk/jsmin-php
   * Coded By eriknyk (Erik Amaru Ortiz)
  */
  require_once(LIBRARY . 'jsmin-php/jsmin.php');

  /*  
   * LESS compiler written in PHP.
   * URL https://github.com/leafo/lessphp
   * Coded By leafo (Leaf Corcoran)
  */
  require_once(LIBRARY . 'lessphp/lessc.inc.php');
  
  /*
   * A port of the CoffeeScript compiler to PHP.
   * URL https://github.com/alxlit/coffeescript-php
   * Coded By alxlit (Alex Little)
  */
  require_once(LIBRARY . 'coffeescript-php/src/CoffeeScript/Init.php');
  

  class Library {
    
    public static function Less($path) {
      $_path = explode(".", $path);
      $_path[count($_path) -1] = "css";
      $output = "";

        $less = new lessc;
        
        Moo::Sandbox(
          $output = $less->compileFile($path)
        );
        
        $path = implode(".", $_path);
        file_put_contents($path, $output, LOCK_EX);

      return $path;
    }
    
    public static function CoffeeScript($path) {
      $_path = explode(".", $path);
      $_path[count($_path) -1] = "js";
      $output = "";
      
        CoffeeScript\Init::load();
      
        Moo::Sandbox(
          $output = CoffeeScript\Compiler::compile(file_get_contents($path), array('filename' => $path))
        );
        
        $path = implode(".", $_path);
        file_put_contents($path, $output, LOCK_EX);
        
      return $path;
    }

  }
?>