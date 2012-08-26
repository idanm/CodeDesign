<?php
	
	interface iCodeDesign {
		public function __construct();
		public static function Run($json);
		public static function Content($context);
	}
	
	interface iMoo {
		public static function Log($content, $console);
		public static function Debug($crazy_stuff, $die);
		public static function SandBox($sand);
		public static function Cache($file, $folder, $switch);
	}
	
	interface iLibrary {
		public static function Less($path);
		public static function CoffeeScript($path);
		public static function Concat($files, $path, $cache_folder, $cached);
		public static function Minify($file, $path, $cache_folder, $cached);
		public static function Markdown($path);
		public static function StylesheetFile($files, $options);
		public static function JavascriptFile($files, $options);
	}
	
?>