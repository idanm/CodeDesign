<?php

  class Code implements iCode {
    private static $content_folder, $stylesheet_tag, $javascript_tag;
    
    public static function Run() {
      $json = Moo::Sandbox(file_get_contents(dirname(__FILE__) . '/../environment.json'));
      $json = Moo::Sandbox(json_decode($json, true, 9));
      self::Laboratory(self::Config($json));
    }
    
    private static function Config($environment) {
      $output = array();
      foreach($environment as $domain => $settings) {
        if ($domain == "default") {
          $output = $environment["default"];
        } else {
          if (Moo::DomainCheck($domain)) {
            foreach ($settings as $options => $attributes) {
              if ((is_array($attributes) && count(array_filter(array_keys($attributes),'is_string')) == count($attributes))) {
                $output[$options] = array_replace_recursive($output[$options], $settings[$options]);
              } else {
                $output[$options] = array_merge($output[$options], $settings[$options]);
              }
            }
          }
        }
      }
      return $output;
    }
    
    private static function Laboratory($input) {
      $_options = $input["config"];
      $output = "";
      
        foreach($input as $settings => $options) {
          switch($settings) {
            case "stylesheet":
              $_options["resources"] =  $input["resources"]["css"];
              self::$stylesheet_tag = File::HtmlTag($options, $_options);
            break;
            case "javascript":
              $_options["resources"] = $input["resources"]["js"];
              self::$javascript_tag = File::HtmlTag($options, $_options);
            break;
            case "helpers":
              if ($input["helpers"]["content"]) {
                self::$content_folder = $input["helpers"]["content"];
              }
            break;
            default:
            break;
          }
        }
        
      return $output;
    }
    
    public static function Content($path) {
      $output = "";
      
        if (!empty(self::$content_folder)) {
          Moo::Sandbox(
            $output = Library::Markdown(self::$content_folder.$path)
          );
        } else {
          $output = "Missing Content Folder.";
        }
        
      echo $output;
    }

    public static function Stylesheet_Files() {
      echo self::$stylesheet_tag;
    }

    public static function Javascript_Files() {
      echo self::$javascript_tag;
    }
    
  }
  
?>