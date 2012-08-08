<?php

	require_once(dirname(__FILE__). '/febuild.library.php'); 

	class FEBuild extends FEBuild_Library {
		private $input, $output, $settings;
		
		public function __construct() {
		$this->input = '';
		$this->output = "";
		$this->settings = array(
			"environment" 	=> "develop",
			"concat"		=> false,
			"path"			=> array(
				"css"		=> "style/common",
				"js"		=> "script/common"
			),
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
						$this->output .= $this->StyleFile($options, $this->settings["concat"]);
					break;
					case "javascript":
						$this->output .= $this->JavascriptFile($options, $this->settings["concat"]);
					break;
					default: 
						echo "No ${options} Options!";
					break;
				}
			}
			
			if ($this->settings["concat"]) {
				$this->output = $this->Library($this->output, 'concat');
			}

		echo $this->Log()->output;
	}
		
		private function Log() {
		if (!empty($_GET["debug"])) {
			$moo = "Big Cow, Says Mooo !!!";
			$this->output .= '<script>console.log("'. $moo .'");</script>';
		}
		
		return $this;
	}
		
		private function Library($path, $extension = false) {
		$extension = empty($extension) ? end(explode(".",$path)) : $extension;
			
			switch($extension) {
				case "less":
					$path = $this->Less($path);
				break;
				case "coffee":
					$path = $this->CoffeeScript($path);
				break;
				case "concat":
					$path = $this->Concat($path, $this->settings["path"]);
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
		
		private function StyleFile($attr, $settings) {
		$output = '';
		
			foreach($attr as $key => $value) {
				$src = $this->Library(is_string($value) ? $value : $value["src"]);
				
				if (!$settings) {
					$media = is_string($value) || empty($value["media"]) ? "screen" : $value["media"];
					$output .= '<link rel="stylesheet" type="text/css" href="'. $src .'" media="'. $media .'">'."\n";
				} else {
					$output .= $src.",";
				}
			}
		
		return $output;
	}
		
		private function JavascriptFile($options, $settings) {
		$output = '';
		
			foreach($options as $key => $value) {
				$value = $this->Library($value);
				
				if (!$settings) {
					$output .= '<script scr="'. $value .'"></script>'."\n";
				} else {
					$output .= $value.",";
				}
			}
			
		return $output;
	}
		
	}
	
?>