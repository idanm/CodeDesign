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
   * SCSS compiler written in PHP.
   * URL https://github.com/leafo/scssphp
   * Coded By leafo (Leaf Corcoran)
  */
  require_once(LIBRARY . 'scssphp/scss.inc.php');
  
  /*
   * A port of the CoffeeScript compiler to PHP.
   * URL https://github.com/alxlit/coffeescript-php
   * Coded By alxlit (Alex Little)
  */
  require_once(LIBRARY . 'coffeescript-php/src/CoffeeScript/Init.php');
  

  class Library {
    
    public static function Less( $file )
    {
      $output = '';
      $less = new lessc;

        $output = $less->compileFile( BASE_URL . $file );
        $file = Moo::changeFileExtension( $file, 'css' );
        file_put_contents( $file, $output, LOCK_EX );

      return $file;
    }

    public static function Scss( $file, $folder )
    {
      $output = '';

        $scss = new scssc();
        $scss->setFormatter('scss_formatter');
        $scss->setImportPaths( BASE_URL . $folder );
        $output = $scss->compile(
          file_get_contents( BASE_URL . $file )
        );

        $file = Moo::changeFileExtension( $file, 'css' );
        file_put_contents( $file, $output, LOCK_EX );

      return $file;
    }
    
    // Tested long long time ago, so I don't think this is working.
    public static function CoffeeScript( $file )
    {
      $output = '';
      
        CoffeeScript\Init::load();
      
        $output = CoffeeScript\Compiler::compile(
          file_get_contents( BASE_URL . $file ), array( 'filename' => $file )
        );
      
        $file = Moo::changeFileExtension( $file, 'js' );
        file_put_contents( $file, $output, LOCK_EX );
        
      return $file;
    }

  }
?>