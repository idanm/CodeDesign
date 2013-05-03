<?php

  // File class
  class File extends Library {
    public $output;

    public function __construct( $output_file, $list, $settings )
    {
      switch ( $this->getFileExtension( $output_file ) ) {
        case 'css':
          $tag = '<link rel="stylesheet" type="text/css" href="#path">';
        break;
        case 'js':
          $tag = '<script src="#path"></script>';
        break;
      }

      foreach( $list as $file ) {
        switch ( $this->getFileExtension( $file ) ) {
          case "less":
            $list[$file] = parent::Less( BASE_URL . $file );
          break;
          case "scss":
            $list[$file] = parent::SCSS( BASE_URL . $file );
          break;
          case "coffee":
            $list[$file] = parent::CoffeeScript( BASE_URL . $file );
          break;
        }
      }

      if ( $settings["concat"] === true && $settings["minify"] === false ) {
        $this->output = str_replace(
          "#path", $this->Concat($list, $output_file, $settings["cache"]), $tag
        );
      } else if ( $properties["minify"] === true ) {
        $this->output = str_replace(
          "#path", $this->Minify($list, $output_file, $settings["cache"]), $tag
        );
      } else {
        foreach( $list as $file ) {
          $this->output .= str_replace(
            "#path", $file, $tag
          );
        }
      }
    }

    protected function getFileExtension( $file )
    {
      $tmp = explode( ".", $file ); return end( $tmp );
    }

    public function __toString() {
      return $this->output;
    }

    private function Create($file, $content, $cached = false) {

      if (!file_exists($file) || (sha1_file($file) != sha1($content))) {
        Moo::Sandbox(
          file_put_contents($file, $content, LOCK_EX)
        );
      }

      return $this->Cache($file, $cached);
    }

    private function Cache($file, $on = false) {
      if ($on === true && file_exists($file)) {
        $file = $file . '?' . date ("YmdHis", filemtime($file));
      }
      
      return $file;
    }

    private function Concat($files, $path, $cached = false) {
      $content = "";

        foreach($files as $key => $file) {
          $content .= trim(file_get_contents($file))."\n\n";
        }
        
      return $this->Create($path, $content, $cached);
    }
    
    private function Minify($files, $path, $cached = false) {
      $tmp = explode(".", $path);
      $file_extension = end($tmp);
      $path = str_replace(".".$file_extension, ".min.".$file_extension, $path);
      $content = "";
      
        foreach($files as $key => $file) {
          switch($file_extension) {
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