<?php

  class File {
    public $output;

    public function __construct($type, $list, $cache, $minify, $concat) {
      switch ($type) {
        case 'stylesheet':

        break;
        case 'javascript':
          
        break;
      }

      $this->output = $type;
    }

    public function __toString() {
      return $this->output;
    }
  }

?>