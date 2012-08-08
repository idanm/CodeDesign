<?php require_once(dirname(__FILE__). '/febuild.library.php'); 

class FEBuild extends FEBuildLibrary {
	protected $output, $settings;
	
	public function __construct() {
		$this->output = "";
		$this->settings = array(
			"environment" 	=> "develop",
			"root_path"		=> "",
			"version"		=> "0.1"
		);
	}
	
	private function SetThings($params) {
		foreach($params as $key => $value) {
			
		}
	}
	
	private function Debug() {
		if (!empty($_GET["debug"])) {
			$moo = "Big Cow, Says Mooo !!!";
			$this->output .= '<script>console.log("'. $moo .'");</script>';
		}
		
		return $this;
	}
	
	private function StyleFile($params) {
		foreach($params as $key => $value) {
			$src = is_string($value) ? $value : $value["src"];
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
						$this->SetThings($params);
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

		echo $this->Debug()->output;
	}
	
	public static function Run($json) {
		if (!empty($json)) {
			$self = new FEBuild(); return $self->Lab($json);
		}
	}
	
}?>