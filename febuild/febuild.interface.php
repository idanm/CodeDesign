<?php
	
	# doesn't work yet.

	interface iFEBuild_Library {
		private function Sandbox($sand);
		public function Less($path);
		public function CoffeeScript($path);
		public function Concat($files);
	}
	
	interface iFEBuild extends iFEBuild_Library {
		public function __construct();
		public static function Run($json);
		private function Lab($input);
		private function Log();
		private function Library($path, $extension = false);
		private function SetThings($options);
		private function StyleFile($attr, $settings);
		private function JavascriptFile($options, $settings);
	}
?>