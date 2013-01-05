<?php

  // File class
  class File extends Library {
    public $output;

    public function __construct(array $properties) {
      Moo::Debug($properties);
      $this->output = $properties['type'];
    }

    public function __toString() {
      return $this->output;
    }
  }

?>