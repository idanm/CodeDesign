<?php

	interface iFEBuild_Library {
		public function Less($path);
		public function CoffeeScript($path);
		public function Concat($files, $path);
		public function Minify($path);
	}
	
?>