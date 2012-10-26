<?php 

  // Environment Mount
  // simple php file for cheking your server and leveling for the software

  // Error Handeling off.
  error_reporting(0);

  // Version Check
  if (!version_compare(PHP_VERSION, '5.3.0', '>')) {
    die("Please update you server's php version to at least 5.3.0");
  }

?>