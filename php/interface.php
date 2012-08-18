<?php
	
	interface iCodeDesign {
		public function __construct();
		public static function Run($json);
		public static function Content($context);
	}
	
	interface iMoo {
		public static function Log();
		public static function Debug($crazy_stuff);
		public static function SandBox($sand);
	}
	
	interface iLibrary {
		public static function Less($path);
		public static function CoffeeScript($path);
		public static function Concat($files, $path);
		public static function Minify($file, $path);
		public static function Markdown($path);
		public static function StylesheetFile($files, $path, $concat = false, $minify = false);
		public static function JavascriptFile($files, $path, $concat = false, $minify = false);
	}
	
?>