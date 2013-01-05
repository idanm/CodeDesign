<?php

  // File class
  class File extends Library {
    public $output;

    public function __construct($properties) {
      $this->output = $properties;
    }

    public function __toString() {
      return $this->output;
    }
  }

?>