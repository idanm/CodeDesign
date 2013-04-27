<?php
  
  // Moo is a maintenance class.
  class Moo {
    
    public static function Debug( $nonsense, $die = false ) {
      if ( $die ) {
        die( var_dump( $nonsense ) );
      } else {
        $output = str_replace("'", "", 
          json_encode( $nonsense, JSON_UNESCAPED_UNICODE )
        );
        echo '<script>console.log('. $output .');</script>';
      }
    }
    
    public static function Sandbox( $sand, $message )
    {
      try {
        $blah = @$sand;

          if ( $blah === false || is_null($blah) ) {
            throw new exception( $message );
          }

        return $blah;
      } catch ( exception $e ) {
        exit( $e->getMessage() );
      }
    }

    public static function Log( $message, $on )
    {
      if ( $on === true ) {

      }

    }    

    public static function checkEnvironment( $server, $environment )
    {
      return $server === $_SERVER["SERVER_NAME"] && $environment === $_ENV["ENVIRONMENT"];
    }

  }
  
?>