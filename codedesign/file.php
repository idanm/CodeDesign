<?php

  // File class
  class File extends Library {
    public $output;

    public function __construct($type, $list, $cache, $minify, $concat) {
      $this->output = $type;
    }

    public function __toString() {
      return $this->output;
    }
  }

?>