<?php class FEBuild {
	protected $output, $settings;
	
	public function __construct() {
		$this->output = "";
		$this->settings = array(
			"environment" 	=> "develop",
			"root_path"		=> "",
			"version"		=> "0.1"
		);
		// http://code.google.com/p/minify/
		// http://code.google.com/p/cssmin/
	}
	
	private function SetThings($params) {
		foreach($params as $key => $value) {
			
		}
	}
	
	private function IfLess($path) {
		/*require_once(dirname(__FILE__) .'/lib/lessc.inc.php');
			try {
				lessc::ccompile($path, $path.'.css');
			} catch (exception $ex) {
				exit('lessc fatal error:<br />'.$ex->getMessage());
			}*/
		return $path;
	}
	
	private function IfDebug() {
		if (!empty($_GET["debug"])) {
			$moo = "Big Cow, Says Mooo !!!";
			$this->output .= '<script>console.log("'. $moo .'");</script>';
		}
		
		return $this;
	}
	
	private function StyleFile($params) {
		foreach($params as $key => $value) {
			$src = $this->IfLess(is_string($value) ? $value : $value["src"]);
			$media = is_string($value) || empty($value["media"]) ? "screen" : $value["media"];
			
			$this->output .= '<link rel="stylesheet" type="text/css" href="'. $src .'" media="'. $media .'">'."\n";
		}
	}
	
	private function JavascriptFile($params) {
		foreach($params as $key => $value) {
			$this->output .= '<script scr="'. $value .'"></script>'."\n";
		}
	}
	
	private function Lab($json) {
		$settings = json_decode($json, true, 9);
			
			foreach($settings as $options => $params) {
				switch($options) {
					case "config":
						//$this->SetThings($params);
					break;
					case "style":
						$this->StyleFile($params);
					break;
					case "javascript":
						$this->JavascriptFile($params);
					break;
					default: 
						echo "No Options ${options}";
					break;
				}
			}

		echo $this->IfDebug()->output;
	}
	
	public static function Run($json) {
		if (!empty($json)) {
			$self = new FEBuild(); return $self->Lab($json);
		}
	}
	
}?>