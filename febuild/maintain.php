<?php
	
	class FEBuild_Maintain implements iFEBuild_Maintain {
	
		public static function Log() {
			$output = "";
			if (!empty($_GET["log"])) {
				$moo = "Big Cow, Says Mooo !!!";
				$output = '<script>console.log("'. $moo .'");</script>';
			}
			
			return $output;
		}
		
		public static function Debug() {
			
		}
	
	}
	
?>