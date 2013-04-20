<?php

  class Settings {
    private static $JSON, $Data;
    private function __construct() {}

    public static function init( $file )
    {
      self::$JSON = Moo::Sandbox(
        json_decode(
          file_get_contents( $file ), true, 9
        )
      );

      foreach( self::$JSON as $domain => $settings )
      {
        if ( $domain == "default" )
        {
          self::$Data = self::$JSON[$domain];
        } 
        else if ( Moo::checkEnvironment( $settings['server_name'], $settings['server_env'], $settings['environment'] ) )
        {
          foreach ( $settings as $options => $attributes ) 
          {
            if ( is_array( $attributes ) && count( array_filter( array_keys( $attributes ), 'is_string' ) ) == count( $attributes ) )
            {
              self::$Data[$options] = array_replace_recursive( self::$Data[$options], $settings[$options] );
            } 
            else
            {
              self::$Data[$options] = array_merge( self::$Data[$options], $settings[$options] );
            }
          }
        }
      }
    }

    private function find( $where, $what, $replace )
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
            return $this->find( $where[$item], $what, $replace )
          }
        }
      }
    }

    // REWRITE to a useful get function with find.
    public static function get( $what )
    {
      if ( !empty( $what ) ) {
        return self::$Data[$what];
      }
    }

    public static function set( $what ) 
    {
      // Write the function with find.
    }

    // Need to be REWRITTEN!!!
    public static function fileProperties( $type, $list, $config )
    {
      $output = array();

        $output['tag']    = self::$Data['config']['tag'][$type];
        $output['path']   = self::$Data['config']['path'][$type];
        $output['list']   = empty($list) ? self::$Data[$type] : array_merge(self::$Data[$type], $list);
        $output['cache']  = empty($config[0]) ? self::$Data['config']['cache']  : $config[0];
        $output['minify'] = empty($config[1]) ? self::$Data['config']['minify'] : $config[1];
        $output['concat'] = empty($config[2]) ? self::$Data['config']['concat'] : $config[2];

      return $output;
    }

  }

?>