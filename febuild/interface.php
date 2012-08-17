<?php

	interface iFEBuild_Library {
		public function Less($path);
		public function CoffeeScript($path);
		public function Concat($files, $path);
		public function Minify($path);
	}
	
	interface iFEBuild_Maintain {
		public static function Log();
		public static function Debug();
	}
	
?>