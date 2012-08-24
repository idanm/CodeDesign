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
		
		public static function Debug($crazy_stuff) {
			die(var_dump($crazy_stuff));
		}
		
		public static function Sandbox($sand) {
			try { return $sand; } catch (exception $e) {
				exit('fatal error:<br />'.$e->getMessage());
			}
		}
		
		public static function Cache($file, $switch) {
			if ($switch === true) {
		
				self::Debug($file);
		
			}
			
			return $file;
		}
	
	}
	
?>