<?php
	
	/*  
	 * LESS compiler written in PHP.
	 * URL https://github.com/leafo/lessphp
	 * Coded By leafo (Leaf Corcoran)
	*/
	require_once(dirname(__FILE__) . '/libs/lessphp/lessc.inc.php');
	
	/*
	 * A port of the CoffeeScript compiler to PHP.
	 * URL https://github.com/alxlit/coffeescript-php
	 * Coded By alxlit (Alex Little)
	*/
	require_once(dirname(__FILE__) . '/libs/coffeescript-php/src/CoffeeScript/Init.php');
	
	/*
	 * PHP Markdown is a port to PHP of the Markdown perl script by John Grubber.
	 * URL https://github.com/michelf/php-markdown
	 * Coded By michelf (Michel Fortin)
	*/
	require_once(dirname(__FILE__) . '/libs/php-markdown/markdown.php');
	

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
		
		public static function Markdown($path) {
			Moo::Sandbox(
				$output = Markdown(file_get_contents($path.".md"))
			);
			return $output;
		}
		
		/*
		 * https://github.com/philipwalton/PW_Zen_Coder
		 * http://code.google.com/p/zen-php/
		 * http://imsky.github.com/holder/
		 */
	}
?>