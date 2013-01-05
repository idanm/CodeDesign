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

  // File class
  class File extends Library {
    public $output;

    public function __construct(array $properties) {
      foreach($properties['list'] as $file) {
        $tmp = explode(".", $file);
        $file_extension = end($tmp);

        switch ($file_extension) {
          case "less":
            $properties['list'][$file] = parent::Less($file);
          break;
          case "coffee":
            $properties['list'][$file] = parent::CoffeeScript($file);
          break;
        }
      }

      if ($properties["concat"] === true && $properties["minify"] === false) {
        $this->output = str_replace("#path", $this->Concat($properties['list'], $properties["path"], $properties["cache"]), $properties["tag"]);
      } else if ($properties["minify"] === true) {
        $this->output = str_replace("#path", $this->Minify($properties['list'], $properties["path"], $properties["cache"]), $properties["tag"]);
      } else {
        foreach($properties['list'] as $file) {
          $this->output .= str_replace("#path", $file, $options["resources"]["tag"]);
        }
      }
    }

    public function __toString() {
      return $this->output;
    }

    public function Create($file, $content, $cached = false) {

      if (!file_exists($file) || (sha1_file($file) != sha1($content))) {
        Moo::Sandbox(
          file_put_contents($file, $content, LOCK_EX)
        );
      }

      return $this->Cache($file, $cached);
    }

    public function Cache($file, $on = false) {
      if ($on === true && file_exists($file)) {
        $file = $file . '?' . date ("YmdHis", filemtime($file));
      }
      
      return $file;
    }

    public function Concat($files, $path, $cached = false) {
      $content = "";

        foreach($files as $key => $file) {
          $content .= trim(file_get_contents($file))."\n\n";
        }
        
      return $this->Create($path, $content, $cached);
    }
    
    public function Minify($files, $path, $cached = false) {
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

      return $this->Create($path, $content, $cached);
    }


  }

?>