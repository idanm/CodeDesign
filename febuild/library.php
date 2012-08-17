<?php
	
	##  
	# LESS compiler written in PHP
	# URL https://github.com/leafo/lessphp
	# Coded By Leaf Corcoran (leafo)
	##
	require_once(dirname(__FILE__) .'/libs/lessphp/lessc.inc.php');
	
	##
	# A port of the CoffeeScript compiler to PHP
	# URL https://github.com/alxlit/coffeescript-php
	# Coded By Alex Little (alxlit)
	##
	require_once(dirname(__FILE__) .'/libs/coffeescript-php/src/CoffeeScript/Init.php');
	
	class FEBuild_Library implements iFEBuild_Library {
		
		public static function Less($path) {
			$_path = explode(".", $path);
			$_path[count($_path) -1] = "css";
			$output = implode(".", $_path);

				FEBuild_Moo::Sandbox(lessc::ccompile($path, $output));
				
			return $output;
		}
		
		public static function CoffeeScript($path) {
			$_path = explode(".", $path);
			$_path[count($_path) -1] = "js";
			$output = "";
			
				CoffeeScript\Init::load();
			
				FEBuild_Moo::Sandbox(
					$output = CoffeeScript\Compiler::compile(file_get_contents($path), array('filename' => $path))
				);
				
				$path = implode(".", $_path);
				file_put_contents($path, $output);
				
			return $path;
		}
	
		public static function Concat($files, $path) {
			$content = "";
			$output = "";
			
				foreach($files as $key => $file) {
					#FEBuild_Moo::Debug($key);
					$content .= trim(file_get_contents($file));
					if ($files[$key] == 0) $output = $path.".".end(explode(".",$file));
				}
			
				FEBuild_Moo::Sandbox(file_put_contents($output, $content));
			
			return $output;
		}
		
		public static function Minify($files) {
			
		}
		
		public static function StylesheetFile($files, $path, $concat = false, $minify = false) {
			$output = "";
			
				foreach($files as $key => $file) {
					if (end(explode(".",$file)) == "less") {
						$files[$key] = self::Less($file);
					}
				}
				
				if ($concat == true) {
					$output = self::Concat($files, $path);
					
					if ($minify == true) {
						$output = self::Minify($output);
					}
					
					$output = '<link rel="stylesheet" type="text/css" href="'. $output .'" media="screen">';
				} else {
					foreach($files as $file) {
						$output .= '<link rel="stylesheet" type="text/css" href="'. $file .'" media="screen">'; 
					}
				}
			
			return $output;
		}
		
		public static function JavascriptFile($files, $path, $concat = false, $minify = false) {
			$output = "";
			
				foreach($files as $key => $file) {
					if (end(explode(".",$file)) == "coffee") {
						$files[$key] = self::CoffeeScript($file);
					}
				}
				
				if ($concat == true) {
					$output = self::Concat($files, $path);
					
					if ($minify == true) {
						$output = self::Minify($output);
					}
					
					$output = '<script src="'. $output .'"></script>';
				} else {
					foreach($files as $file) {
						$output .= '<script src="'. $file .'"></script>'; 
					}
				}
			
			return $output;
		}
		
		# https://github.com/michelf/php-markdown/
		# https://github.com/philipwalton/PW_Zen_Coder
		# http://code.google.com/p/minify/
		# http://code.google.com/p/zen-php/
		# http://code.google.com/p/cssmin/
		# http://leafo.net/scssphp/
		# http://code.google.com/p/phamlp/
		# http://imsky.github.com/holder/

/*
// This function is probably too simple to use: It can bite.

function replace_tabs_newlines($content) {

    return preg_replace('(\r|\n|\t)', '', $content);

}
*/
	}
?>