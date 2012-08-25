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
		public static function Cache($file, $folder, $switch);
	}
	
	interface iLibrary {
		public static function Less($path);
		public static function CoffeeScript($path);
		public static function Concat($files, $path, $cached);
		public static function Minify($file, $path, $cached);
		public static function Markdown($path);
		public static function StylesheetFile($files, $options);
		public static function JavascriptFile($files, $options);
	}
	
?>