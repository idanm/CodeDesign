<?php

  // File class
  class File extends Library {
    public $output;
    private static $cache;

    public function __construct( $output_file, $list, $settings )
    {
      switch ( Moo::getFileExtension( $output_file ) ) {
        case 'css':
          $tag = '<link rel="stylesheet" type="text/css" href="#path">';
        break;
        case 'js':
          $tag = '<script src="#path"></script>';
        break;
      }

      for( $i = 0; $i < count( $list ); $i = $i + 1 ) {
        switch ( Moo::getFileExtension( $list[$i] ) ) {
          case "less":
            $list[$i] = parent::Less( $list[$i] );
          break;
          case "scss":
            $list[$i] = parent::Scss( $list[$i], $settings['folders']['css'] );
          break;
          case "coffee":
            $list[$i] = parent::CoffeeScript( $list[$i] );
          break;
        }
      }

      self::$cache = $settings["cache"];

      if ( $settings["concat"] === true && $settings["minify"] === false ) {
        $this->output = str_replace(
          "#path", $this->Concat( $list, $output_file ), $tag
        );
      } else if ( $settings["minify"] === true ) {
        $this->output = str_replace(
          "#path", $this->Minify( $list, $output_file ), $tag
        );
      } else {
        foreach( $list as $file ) {
          $this->output .= str_replace(
            "#path", $file, $tag
          );
        }
      }
    }

    public function __toString() {
      return $this->output;
    }

    private function Create( $file, $content )
    {

      if ( !file_exists( $file ) || ( sha1_file( $file ) !== sha1( $content ) ) ) {
        file_put_contents($file, $content, LOCK_EX);
      }

      if ( self::$cache ) {
        $file = $this->Cache($file);
      }

      return $file;
    }

    private function Cache( $file )
    {
      if ( file_exists( $file ) ) {
        $file = $file . '?' . date ("YmdHis", filemtime($file));
      }
      
      return $file;
    }

    private function Concat( $files, $path )
    {
      $content = "";

        foreach( $files as $file ) {
          $content .= trim( file_get_contents( $file ) )."\n\n";
        }
        
      return $this->Create($path, $content);
    }
    
    private function Minify( $files, $path )
    {
      $tmp = explode(".", $path);
      $file_extension = end($tmp);
      $path = str_replace(".".$file_extension, ".min.".$file_extension, $path);
      $content = "";
      
        foreach($files as $key => $file) {
          switch($file_extension) {
            case "css":
              $content .= CssMin::minify(file_get_contents($file), array("RemoveComments" => false))."\n\n";
            break;
            case "js":
              $content .= JSMin::minify(file_get_contents($file))."\n\n";
            break;
            default:
            break;
          }
        }

      return $this->Create($path, $content);
    }


  }

?>