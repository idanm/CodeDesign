<?php class FEBuildLibrary {
	
	static protected function Less($input, $output) {
		
		require_once(dirname(__FILE__) .'/libs/lessc.inc.php');
			try {
				lessc::ccompile($input, $output);
			} catch (exception $ex) {
				exit('lessc fatal error:<br />'.$ex->getMessage());
			}
	}
	
	// https://github.com/alxlit/coffeescript-php
	// http://code.google.com/p/minify/
	// http://code.google.com/p/cssmin/
	// http://code.google.com/p/phamlp/
	
}?>
