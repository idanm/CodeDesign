<?php

	##
	# FEBuild
	# deploying easily styles and javascript files in php environment.
	# 
	# @author idanm
	##
	
	
	##
	# System Files
	##
	require_once(dirname(__FILE__). '/interface.php');
	require_once(dirname(__FILE__). '/maintenance.php');
	require_once(dirname(__FILE__). '/library.php');
	
	#
	class FEBuild implements iFEBuild {
		public static $markdown;
		private $input, $output, $settings;
		
		public function __construct() {
			static::$markdown = false;
			$this->input = "";
			$this->output = "";
			$this->settings = array(
				"concat"		=> false,
				"minify"		=> false,
				"path"			=> array(
					"css"		=> "style/common",
					"js"		=> "script/common"
				)
			);
		}
		
		public static function Run($json) {
			if (!empty($json)) {
				$self = new FEBuild(); return $self->Laboratory($json);
			}
		}
		
		private function Laboratory($input) {
			$this->input = json_decode($input, true, 9);
			
				foreach($this->input as $settings => $options) {
					if ($settings == "config") {
						$this->SetThings($options);						
					} else {
						$this->output .= $this->Library($settings, $options);
					}
				}
	
			echo $this->output;
		}
		
		private function SetThings($options) {
			foreach($options as $key => $value) {
				if (!empty($value)) {
					$this->settings[$key] = $value;
				}
			}
		}
		
		private function Library($markup, $files, $path = false) {
			$output = "";
			
				switch($markup) {
					case "stylesheet":
						$output = FEBuild_Library::StylesheetFile($files, $this->settings["path"]["css"], $this->settings["concat"], $this->settings["minify"]);
					break;
					case "javascript":
						$output = FEBuild_Library::JavascriptFile($files, $this->settings["path"]["js"], $this->settings["concat"], $this->settings["minify"]);
					break;
					case "markdown":
						static::$markdown = $files;
					break;
					default:
					break;
				}
			
			return $output;
		}
		
		public static function Content($context) {
			$output = "";
			
				if (static::$markdown) {
					$output = FEBuild_Library::Markdown(static::$markdown, $context);
				} else {
					$output = "have no {$context} markdown files.";
				}
				
			return $output;
		}
		
	}
	
?>