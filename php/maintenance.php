<?php
	
	##
	# Moo is a maintenance class.
	##
	
	class Moo implements iMoo {
	
		public static function Log() {
			$output = "";
		
			if (!empty($_GET["log"])) {
				$moo = "Big Cow, Says Mooo !!!";
				$output = '<script>console.log("'. $moo .'");</script>';
			}
			
			return $output;
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
				self::Debug($folder.$file);
			}
			
			return $file;
		}
	
	}
	
?>