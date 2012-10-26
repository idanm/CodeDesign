<?php

  /*
   * CodeDesign
   * deploying easily styles and javascript files in php environment.
   * 
   * @author idanm
  */

  // Environment check and level
  require_once(dirname(__FILE__) . '/environment-mount.php');

  // System Files
  require_once(dirname(__FILE__) . '/interface.php');
  require_once(dirname(__FILE__) . '/library.php');
  require_once(dirname(__FILE__) . '/file.php');
  require_once(dirname(__FILE__) . '/maintenance.php');

  // Helpers
  // require_once(dirname(__FILE__) . '/helpers/content.php');
  
  class CodeDesign implements iCodeDesign {
    private static $content_folder;
    
    public static function Run() {
      $json = Moo::Sandbox(file_get_contents('config/environment.json'), 'bla!');
      $json = Moo::Sandbox(json_decode($json, true, 9), 'da!');

      echo self::Laboratory(self::Config($json));
    }

    private static function MakeEnv($default, $domain) {
      foreach ($domain as $settings => $options) {
          $default[$settings] = array_replace_recursive($default[$settings], $domain[$settings]);
        if ((is_array($options) && count(array_filter(array_keys($options),'is_string')) == count($options))) {
        } else {
          $default[$settings] = array_merge($default[$settings], $domain[$settings]);
        }
      }
      
      return $default;
    }
    
    private static function Config($environment) {
      $output = array();

      foreach($environment as $domain => $settings) {
        if ($domain == "default") {
          $output = $environment["default"];
        } else {
          if (Moo::DomainCheck($domain)) {
            $output = self::MakeEnv($output, $settings);
          }
        }
      }
      
      return $output;
    }
    
    private static function Laboratory($input) {
      $_options = array(
        "cache" => $input["config"]["cache"],
        "concat" => $input["config"]["concat"],
        "minify" => $input["config"]["minify"]
      );
      $output = "";
      
        foreach($input as $settings => $options) {
          switch($settings) {
            case "stylesheet":
              $_options["resources"] =  $input["resources"]["css"];
              $output .= File::HtmlTag($options, $_options);
            break;
            case "javascript":
              $_options["resources"] = $input["resources"]["js"];
              $output .= File::HtmlTag($options, $_options);
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
        
      return $output;
    }
    
  }
  
?>