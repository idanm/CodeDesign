<?php class FEBuild {
	protected $output, $settings;
	
	public function __construct() {
		$this->output = "";
		$this->settings = array(
			"environment": "develop", // develop, production 
			"root_path": "",
			"version": "0.1"
		);
		// http://code.google.com/p/minify/
		// http://code.google.com/p/cssmin/
	}
	
	private function IfLess($path) {
		return $path;
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
		$moo = "Big Cow, Says Mooo !!!";
			
			foreach($settings as $options => $params) {
				switch($options) {
					case "config":
						
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
		
		echo $this->output . $moo;
	}
	
	public static function Run($json) {
		if (!empty($json)) {
			$self = new FEBuild(); return $self->Lab($json);
		}
	}
	
}?>