<?php
	
	/*  
	LESS compiler written in PHP
	URL https://github.com/leafo/lessphp
	Coded By Leaf Corcoran (leafo)
	*/
	require_once(dirname(__FILE__) .'/libs/lessphp/lessc.inc.php');
	
	/*
	A port of the CoffeeScript compiler to PHP
	URL https://github.com/alxlit/coffeescript-php
	Coded By Alex Little (alxlit)
	*/
	require_once(dirname(__FILE__) .'/libs/coffeescript-php/src/CoffeeScript/Init.php');
	
	class FEBuild_Library {
	
		private function Sandbox($sand) {
			try { $sand; } catch (exception $e) {
				exit('fatal error:<br />'.$e->getMessage());
			}
		}
		
		protected function Less($path) {
			$_path = explode(".", $path);
			$_path[count($_path) -1] = "css";
			$output = implode(".", $_path);

				$this->Sandbox(lessc::ccompile($path, $output));
			
			return $output;
		}
		
		protected function CoffeeScript($path) {
			$_path = explode(".", $path);
			$_path[count($_path) -1] = "js";
			$output = "";
			
			CoffeeScript\Init::load();
			
				$this->Sandbox($output = CoffeeScript\Compiler::compile(file_get_contents($path), array('filename' => $path)));
				$path = implode(".", $_path);
				file_put_contents($path, $output);
				
			return $path;
		}
	
		# http://leafo.net/scssphp/
		# https://github.com/michelf/php-markdown/
		# http://code.google.com/p/minify/
		# http://code.google.com/p/cssmin/
		# http://code.google.com/p/phamlp/		
	}
?>