<?php
  
  function Stylesheet (
    array $list = array(),
    $cache = NULL,
    $minify = NULL,
    $concat = NULL
  ) {
    echo (new File(
      Config::FileProperties('stylesheet', $list, array($cache, $minify, $concat))
    ));
  }
    
  function Javascript (
    array $list = array(),
    $cache = NULL,
    $minify = NULL,
    $concat = NULL
  ) {
    echo (new File(
      Config::FileProperties('javascript', $list, array($cache, $minify, $concat))
    ));
  }
  
?> 