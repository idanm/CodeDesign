<?php
  
  // Moo is a maintenance class.
  class Moo implements iMoo {
  
    public static function Log($content, $console) {
      $output = date("[Y/m/d H:i:s] ").$content."\n";
      file_put_contents("logs/moo.log", $output, FILE_APPEND | LOCK_EX);
      if ($console) self::Debug($output);
    }

    public static function Message($path) {
      $messages = json_decode(
        file_get_contents('config/messages.json'), true, 9
      );
      $echo = "";
      $path = explode(".", $path);
      $length = count($path);

        for ($i = 0; $i <= $length; $i++) {
          self::Debug($messages[$path[$i]]);
          #$messages = $messages[$path[$i]];

          if ($i == $length) {
            $echo = $messages;
          }
        }

      return $echo;
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
    
    public static function Sandbox($sand, $message = '') {
      try { return $sand; } catch (exception $e) {
        // $e->getMessage();
        exit($message);
      }
    }
    
    public static function DomainCheck($domain) {
      return $domain == $_SERVER["SERVER_NAME"];
    }

  }
  
?>