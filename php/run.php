<?php

  /*
   * CodeDesign
   * deploying easily styles and javascript files in php environment.
   * 
   * @author idanm
  */
  
  // System Files
  require_once(dirname(__FILE__) . '/interface.php');
  require_once(dirname(__FILE__) . '/library.php');
  require_once(dirname(__FILE__) . '/file.php');
  require_once(dirname(__FILE__) . '/maintenance.php');

  // Helpers
  require_once(dirname(__FILE__) . '/helpers/content.php');
  

  class CodeDesign implements iCodeDesign {
    public static $content_folder;
    
    public static function Run($json) {
      $output = array();
      
      if (!empty($json)) {
        $output = self::Laboratory($json);
      } else {
        Moo::Log("Run Failed: No config.json file found", true);
      }
      
      return $output;
    }

    private static function MakeEnv($default, $domain) {
      foreach ($domain as $settings => $options) {
        if ((is_array($options) && count(array_filter(array_keys($options),'is_string')) == count($options))) {
          $default[$settings] = array_replace_recursive($default[$settings], $domain[$settings]);
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
      $input = self::Config(
        json_decode($input, true, 9)
      );
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
    
  }
  
?>