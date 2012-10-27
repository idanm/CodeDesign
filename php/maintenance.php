<?php
  
  // Moo is a maintenance class.
  class Moo implements iMoo {
  
    public static function Log($content, $console) {
      $output = date("[Y/m/d H:i:s] ").$content."\n";
      file_put_contents("moo.log", $output, FILE_APPEND | LOCK_EX);
      if ($console) self::Debug($output);
    }
    
    public static function Debug($crazy_stuff, $die = false) {
      if ($die) {
        die(var_dump($crazy_stuff));
      } else {
        $output = str_replace("'", "", 
          var_export(json_encode($crazy_stuff,  JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), true)
        );
        echo '<script>console.log('. $output .');</script>';
      }
    }
    
    public static function Sandbox($sand) {
      try { return $sand; } catch (exception $e) {
        exit($e->getMessage());
      }
    }
    
    public static function DomainCheck($domain) {
      return $domain == $_SERVER["SERVER_NAME"];
    }

  }
  
?>