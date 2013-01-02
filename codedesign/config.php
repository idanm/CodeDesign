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
        } else {
          if ($domain == $server_name) {
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
    }

    public static function Get($value) {
      if (!empty($value)) {
        return self::$Data[$value];
      }
    }

  }

?>