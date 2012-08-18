<?php
	
	##  
	# LESS compiler written in PHP
	# URL https://github.com/leafo/lessphp
	# Coded By leafo (Leaf Corcoran)
	##
	require_once(dirname(__FILE__) .'/libs/lessphp/lessc.inc.php');
	
	##
	# A port of the CoffeeScript compiler to PHP
	# URL https://github.com/alxlit/coffeescript-php
	# Coded By alxlit (Alex Little)
	##
	require_once(dirname(__FILE__) .'/libs/coffeescript-php/src/CoffeeScript/Init.php');
	
	##
	# A (simple) css minifier with benefits
	# URL https://github.com/brunschgi/cssmin
	# Coded By brunschgi (Remo Brunschwiler)
	##
	require_once(dirname(__FILE__) .'/libs/cssmin/cssmin.php');
	
	##
	# UNMAINTAINED PHP port of Douglas Crockford's JSMin JavaScript minifier.
	# URL https://github.com/rgrove/jsmin-php
	# Coded By rgrove (Ryan Grove)
	##
	require_once(dirname(__FILE__) .'/libs/jsmin-php/jsmin.php');
	
	##
	# UNMAINTAINED PHP port of Douglas Crockford's JSMin JavaScript minifier.
	# URL https://github.com/michelf/php-markdown
	# Coded By michelf (Michel Fortin)
	##
	require_once(dirname(__FILE__) .'/libs/php-markdown/markdown.php');
	
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
					$content .= trim(file_get_contents($file));
					if ($files[$key] == 0) $output = $path.".".end(explode(".",$file));
				}
			
				FEBuild_Moo::Sandbox(file_put_contents($output, $content));
			
			return $output;
		}
		
		public static function Minify($file, $path) {
			$extension = end(explode(".",$file));
			$output = $path.'.min.'.$extension;
			
				switch($extension) {
					case "css":
						FEBuild_Moo::Sandbox(
							file_put_contents($output, CssMin::minify(file_get_contents($file)))
						);
					break;
					case "js":
						FEBuild_Moo::Sandbox(
							file_put_contents($output, JSMin::minify(file_get_contents($file)))
						);						
					break;
					default:
					break;
				}
			
			return $output;
		}
		
		public static function Markdown($path, $filename) {
			$output = FEBuild_Moo::Sandbox(
				Markdown(file_get_contents($path.$filename.".md"))
			);
			return $output;
		}
		
		public static function StylesheetFile($files, $path, $concat = false, $minify = false) {
			$tag = '<link rel="stylesheet" type="text/css" href="#path" media="screen">';
			$output = "";
			
				foreach($files as $key => $file) {
					if (end(explode(".",$file)) == "less") {
						$files[$key] = self::Less($file);
					}
				}
				
				if ($concat == true) {
					$output = self::Concat($files, $path);
					
					if ($minify == true) {
						$output = self::Minify($output, $path);
					}
					
					$output = str_replace("#path", $output, $tag);
				} else {
					foreach($files as $file) {
						$output .= str_replace("#path", $file, $tag);
					}
				}
			
			return $output;
		}
		
		public static function JavascriptFile($files, $path, $concat = false, $minify = false) {
			$tag = '<script src="#path"></script>';
			$output = "";
			
				foreach($files as $key => $file) {
					if (end(explode(".",$file)) == "coffee") {
						$files[$key] = self::CoffeeScript($file);
					}
				}
				
				if ($concat == true) {
					$output = self::Concat($files, $path);
					
					if ($minify == true) {
						$output = self::Minify($output, $path);
					}
					
					$output = str_replace("#path", $output, $tag);
				} else {
					foreach($files as $file) {
						$output .= str_replace("#path", $file, $tag);
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