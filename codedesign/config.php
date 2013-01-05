<?php

  class Config {
    private static $JSON, $Data;
    private function __construct() {}

    public static function Set($file, $server_name) {
      self::$JSON = Moo::Sandbox(
        json_decode(
          file_get_contents($file), true, 9
        )
      );

      foreach(self::$JSON as $domain => $settings) {
        if ($domain == "default") {
          self::$Data = self::$JSON[$domain];
        } else if ($domain == $server_name) {
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

        switch ($type) {
          case 'stylesheet':
            $output['list'] = array_merge(self::$Data['stylesheet'], $list);
            $output['tag']  = self::$Data['config']['tag']['stylesheet'];
            $output['path'] = self::$Data['config']['path']['stylesheet'];
          break;
          case 'javascript':
            $output['list'] = array_merge(self::$Data['javascript'], $list);
            $output['tag']  = self::$Data['config']['tag']['javascript'];
            $output['path'] = self::$Data['config']['path']['javascript'];
          break;
        }

        if (!empty($config)) {
          $output['cache']  = $config[0] !== NULL ? $config[0] : self::$Data['config']['cache'];
          $output['minify'] = $config[1] !== NULL ? $config[1] : self::$Data['config']['minify'];
          $output['concat'] = $config[2] !== NULL ? $config[2] : self::$Data['config']['concat'];
        }

        $output['type'] = $type;

      return $output;
    }

  }

?>