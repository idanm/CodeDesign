<?php
	
	##
	# Moo is a maintenance class.
	##
	
	class Moo implements iMoo {
	
		public static function Log($content, $console) {
			if ($console) self::Debug($content);
			
			$file = "php/moo.log";
			$output = date("[Y/m/d H:i:s] ").$content."\n";
			
			file_put_contents($file, $output, FILE_APPEND);
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
				exit('fatal error:<br />'.$e->getMessage());
			}
		}
		
		public static function Cache($file, $folder, $switch = false) {
		 	if ($switch === true) {
		 		$file = $folder.$file;
		 				 		
		 		if (file_exists($file)) {
			 		
		 		} else {
			 		self::Log("Cache Failed: file doesnt exsits", true);
		 		}
		 		
				self::Debug($file, true);
			}
			
			return $file;
		}
	
	}
	
?>