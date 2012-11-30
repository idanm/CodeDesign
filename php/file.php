<?php 

  /*
   * A (simple) css minifier with benefits
   * URL https://github.com/brunschgi/cssmin
   * Coded By brunschgi (Remo Brunschwiler)
  */
  require_once(dirname(__FILE__) . '/libs/cssmin/cssmin.php');
  
  /*
   * PHP port of Douglas Crockford's JSMin JavaScript minifier. (Maintained version)
   * URL https://github.com/eriknyk/jsmin-php
   * Coded By eriknyk (Erik Amaru Ortiz)
  */
  require_once(dirname(__FILE__) . '/libs/jsmin-php/jsmin.php');


  class File implements iFile {

    public static function Create($file, $content, $cached = false) {

      if (!file_exists($file) || (file_exists($file) && sha1_file($file) != sha1($content))) {
        Moo::Sandbox(
          file_put_contents($file, $content, LOCK_EX)
        );
      }

      return self::Cache($file, $cached);
    }

    public static function HtmlTag($files, $options) {
      $output = "";
      
        foreach($files as $key => $file) {
          switch (end(explode(".", $file))) {
            case "less":
              $files[$key] = Library::Less($file);
            break;
            case "coffee":
              $files[$key] = Library::CoffeeScript($file);
            break;
            default:
            break;
          }
        }

        if ($options["concat"] === true && $options["minify"] === false) {
          $output = str_replace("#path", self::Concat($files, $options["resources"]["path"], $options["cache"]), $options["resources"]["tag"]);
        } else if ($options["minify"] === true) {
          $output = str_replace("#path", self::Minify($files, $options["resources"]["path"], $options["cache"]), $options["resources"]["tag"]);
        } else {
          foreach($files as $file) {
            $output .= str_replace("#path", $file, $options["resources"]["tag"]);
          }
        }
        
      return $output;
    }

    public static function Cache($file, $on = false) {
      if ($on === true && file_exists($file)) {
        $file = $file . '?' . date ("YmdHis", filemtime($file));
      }
      
      return $file;
    }

    public static function Concat($files, $path, $cached = false) {
      $content = "";
      
        foreach($files as $key => $file) {
          $content .= trim(file_get_contents($file))."\n\n";
        }
        
      return self::Create($path, $content, $cached);
    }
    
    public static function Minify($files, $path, $cached = false) {
      $extension = end(explode(".",$path));
      $path = str_replace(".".$extension, ".min.".$extension, $path);
      $content = "";
      
        foreach($files as $key => $file) {
          switch($extension) {
            case "css":
              Moo::Sandbox(
                $content .= CssMin::minify(file_get_contents($file), array("RemoveComments" => false))."\n\n"
              );
            break;
            case "js":
              Moo::Sandbox(
                $content .= JSMin::minify(file_get_contents($file))."\n\n"
              );
            break;
            default:
            break;
          }
        }

      return self::Create($path, $content, $cached);
    }

  }

?>