<?php

  class Config {
    private static $JSON, $Data;
    private function __construct() {}

    public static function Set($file, $environment) {
      self::$JSON = Moo::Sandbox(
        json_decode(
          file_get_contents($file), true, 9
        )
      );

      foreach(self::$JSON as $domain => $settings) {
        if ($domain == "default") {
          self::$Data = self::$JSON[$domain];
        } else if ($domain == $environment) {
          foreach ($settings as $options => $attributes) {
            if ((is_array($attributes) && count(array_filter(array_keys($attributes),'is_string')) == count($attributes))) {
              self::$Data[$options] = array_replace_recursive(self::$Data[$options], $settings[$options]);
            } else {
              self::$Data[$options] = array_merge(self::$Data[$options], $settings[$options]);
            }
          }
        }
      }
    }

    // REWRITE to a useful get function
    public static function Get($value) {
      if (!empty($value)) {
        return self::$Data[$value];
      }
    }

    // Need to be REWRITTEN!!!
    public static function FileProperties($type, $list, $config) {
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