<?php class FEBuildLibrary {
	
	static protected function Less($path) {
		/*require_once(dirname(__FILE__) .'/lib/lessc.inc.php');
			try {
				lessc::ccompile($path, $path.'.css');
			} catch (exception $ex) {
				exit('lessc fatal error:<br />'.$ex->getMessage());
			}*/
		return $path;
	}
	
	static protected function Scss($path) {
		
	}

	static protected function CoffeeScript($path) {
		
	}
	
	// http://code.google.com/p/minify/
	// http://code.google.com/p/cssmin/
	
}?>