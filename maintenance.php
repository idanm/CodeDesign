<?php
  
  // Moo is a maintenance class.
  class Moo {
    
    public static function Debug($crazy_stuff, $die = false) {
      if ($die) {
        die(var_dump($crazy_stuff));
      } else {
        $output = str_replace("'", "", 
          json_encode($crazy_stuff, JSON_UNESCAPED_UNICODE)
        );
        echo '<script>console.log('. $output .');</script>';
      }
    }
    
    public static function Sandbox($sand) {
      try { return $sand; } catch (exception $e) {
        exit($e->getMessage());
      }
    }

  }
  
?>