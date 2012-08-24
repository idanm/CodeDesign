<?php
	
	##  
	# LESS compiler written in PHP.
	# URL https://github.com/leafo/lessphp
	# Coded By leafo (Leaf Corcoran)
	##
	require_once(dirname(__FILE__) .'/libs/lessphp/lessc.inc.php');
	
	##
	# A port of the CoffeeScript compiler to PHP.
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
	# PHP Markdown is a port to PHP of the Markdown perl script by John Grubber.
	# URL https://github.com/michelf/php-markdown
	# Coded By michelf (Michel Fortin)
	##
	require_once(dirname(__FILE__) .'/libs/php-markdown/markdown.php');
	
	class Library implements iLibrary {
		
		public static function Less($path) {
			$_path = explode(".", $path);
			$_path[count($_path) -1] = "css";
			$output = "";

				$less = new lessc;
				
				Moo::Sandbox(
					$output = $less->compileFile($path)
				);

				$path = implode(".", $_path);
				file_put_contents($path, $output, LOCK_EX);
								
				
			return $path;
		}
		
		public static function CoffeeScript($path) {
			$_path = explode(".", $path);
			$_path[count($_path) -1] = "js";
			$output = "";
			
				CoffeeScript\Init::load();
			
				Moo::Sandbox(
					$output = CoffeeScript\Compiler::compile(file_get_contents($path), array('filename' => $path))
				);
				
				$path = implode(".", $_path);
				file_put_contents($path, $output, LOCK_EX);
				
			return $path;
		}
	
		public static function Concat($files, $path, $cached = false) {
			$content = "";
			
				foreach($files as $key => $file) {
					$content .= trim(file_get_contents($file))."\n\n";
				}
			
				Moo::Sandbox(
					file_put_contents(Moo::Cache($path, $cached), $content, LOCK_EX)
				);
			
			return $path;
		}
		
		public static function Minify($files, $path, $cached = false) {
			$extension = end(explode(".",$path));
			$path = str_replace(".".$extension, ".min.".$extension, $path);
			$content = "";
			
				foreach($files as $key => $file) {
					switch($extension) {
						case "css":
							Moo::Sandbox(
								$content .= CssMin::minify(file_get_contents($file), array("RemoveComments" => false))."\n\n"
							);
						break;
						case "js":
							Moo::Sandbox(
								$content .= JSMin::minify(file_get_contents($file))."\n\n"
							);
						break;
						default:
						break;
					}
				}
				
				Moo::Sandbox(
					file_put_contents(Moo::Cache($path, $cached), $content, LOCK_EX)
				);
				
			return $path;
		}
		
		public static function Markdown($path) {
			Moo::Sandbox(
				$output = Markdown(file_get_contents($path.".md"))
			);
			return $output;
		}
		
		public static function StylesheetFile($files, $options) {
			$tag = '<link rel="stylesheet" type="text/css" href="#path" media="screen">';
			$output = "";
			
				foreach($files as $key => $file) {
					if (end(explode(".",$file)) == "less") {
						$files[$key] = self::Less($file);
					}
				}
				
				if ($options["concat"] === true && $options["minify"] === false) {
					$output = str_replace("#path", self::Concat($files, $options["path"]), $tag);
				} else if ($options["minify"] === true) {
					$output = str_replace("#path", self::Minify($files, $options["path"]), $tag);
				} else {
					foreach($files as $file) {
						$output .= str_replace("#path", $file, $tag);
					}
				}
			
			return $output;
		}
		
		public static function JavascriptFile($files, $options) {
			$tag = '<script src="#path"></script>';
			$output = "";
			
				foreach($files as $key => $file) {
					if (end(explode(".",$file)) == "coffee") {
						$files[$key] = self::CoffeeScript($file);
					}
				}
				
				if ($options["concat"] == true && $options["minify"] === false) {
					$output = str_replace("#path", self::Concat($files, $options["path"], $options["cache"]), $tag);
				} else if ($options["minify"] === true) {
					$output = str_replace("#path", self::Minify($files, $options["path"], $options["cache"]), $tag);
				} else {
					foreach($files as $file) {
						$output .= str_replace("#path", $file, $tag);
					}
				}
			
			return $output;
		}
		
		# https://github.com/philipwalton/PW_Zen_Coder
		# http://code.google.com/p/zen-php/
		# http://imsky.github.com/holder/

/*
// This function is probably too simple to use: It can bite.

function replace_tabs_newlines($content) {

    return preg_replace('(\r|\n|\t)', '', $content);

}
*/
	}
?>