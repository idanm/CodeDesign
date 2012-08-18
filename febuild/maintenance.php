<?php
	
	##
	# Moo is a maintenance class.
	##
	
	class FEBuild_Moo implements iFEBuild_Moo {
	
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
	
	}
	
?>