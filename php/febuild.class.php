<?php require_once(dirname(__FILE__). '/febuild.library.php'); 

class FEBuild extends FEBuild_Library {
	protected $input, $output, $settings;
	
	public function __construct() {
		$this->input = '';
		$this->output = "";
		$this->settings = array(
			"environment" 	=> "develop",
			"version"		=> "0.1"
		);
	}
	
	public static function Run($json) {
		if (!empty($json)) {
			$self = new FEBuild(); return $self->Lab($json);
		}
	}
	
	private function Lab($input) {
		$this->input = json_decode($input, true, 9);
			
			foreach($this->input as $settings => $options) {
				switch($settings) {
					case "config":
						$this->SetThings($options);
					break;
					case "style":
						$this->StyleFile($options);
					break;
					case "javascript":
						$this->JavascriptFile($options);
					break;
					default: 
						echo "No ${options} Options!";
					break;
				}
			}

		echo $this->Debug()->output;
	}
	
	private function Debug() {
		if (!empty($_GET["debug"])) {
			$moo = "Big Cow, Says Mooo !!!";
			$this->output .= '<script>console.log("'. $moo .'");</script>';
		}
		
		return $this;
	}	
	
	private function IfLib($path) {
		$extension = end(explode(".",$path));
			
			switch($extension) {
				case "less":
					$path = $this->Less($path);
				break;
				case "coffee":
					$path = $this->CoffeeScript($path);
				break;
				default:
				break;
			}
		
		return $path;
	}
	
	private function SetThings($options) {
		foreach($options as $key => $value) {
			$this->settings[$key] = $value;
		}
	}
	
	private function StyleFile($options) {
		foreach($options as $key => $value) {
			$src = $this->IfLib(is_string($value) ? $value : $value["src"]);
			$media = is_string($value) || empty($value["media"]) ? "screen" : $value["media"];
			
			$this->output .= '<link rel="stylesheet" type="text/css" href="'. $src .'" media="'. $media .'">'."\n";
		}
	}
	
	private function JavascriptFile($options) {
		foreach($options as $key => $value) {
			$this->output .= '<script scr="'. $this->IfLib($value) .'"></script>'."\n";
		}
	}
	
}?>