<?php

  class Settings {
    private static $JSON, $Params;
    private function __construct() {}

    public static function init( $file )
    {
      self::$JSON = Moo::Sandbox(
        json_decode( file_get_contents( $file ), true, 9), 'Invalid environment file ('. ENV_FILE .')'
      );

      foreach( self::$JSON as $domain => $settings )
      {
        if ( $domain == "default" ) {
          self::$Params = self::$JSON[$domain];
        } else if ( Moo::checkEnvironment( $settings['server_name'], $settings['environment'] ) ) {
          foreach ( $settings as $options => $attributes ) 
          {
            if ( is_array( $attributes ) ) {
              if ( count( array_filter( array_keys( $attributes ), 'is_string' ) ) == count( $attributes ) ) {
                self::$Params[$options] = array_replace_recursive( self::$Params[$options], $settings[$options] );
              } else {
                self::$Params[$options] = array_merge( self::$Params[$options], $settings[$options] ); 
              }
            }  else {
              self::$Params[$options] = $settings[$options];
            }
          }
        }
      }
    }

    private function find( $where, $what, $replace = '' )
    {
      if ( empty( $what ) ) {
        return $where;
      }

      $what = explode('.', $what);

      foreach ( $where as $item ) {
        if ( $what[0] === $item ) {
          $what = array_slice( $what, 1 );

          if ( count( $what ) === 0 ) {
            if ( !empty( $replace ) ) {
              $where[$item] = $replace;
            }
            return $where[$item];
          } else {
            return $this->find( $where[$item], $what, $replace );
          }
        }
      }
    }

    // REWRITE to a useful get function with find.
    public static function get( $what = '' )
    {
      return !empty( $what )
        ? $this->find( self::$Params, $what )
        : self::$Params;
    }

    public static function set( $what, $replace )
    {
      // Write the function with find.
    }

    // Need to be REWRITTEN!!!
    public static function fileProperties( $type, $list, $config )
    {
      $output = array();

        $output['tag']    = self::$Params['config']['tag'][$type];
        $output['path']   = self::$Params['config']['path'][$type];
        $output['list']   = empty($list) ? self::$Params[$type] : array_merge(self::$Params[$type], $list);
        $output['cache']  = empty($config[0]) ? self::$Params['config']['cache']  : $config[0];
        $output['minify'] = empty($config[1]) ? self::$Params['config']['minify'] : $config[1];
        $output['concat'] = empty($config[2]) ? self::$Params['config']['concat'] : $config[2];

      return $output;
    }

  }

?>