<?php

	##
	# CodeDesign
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
	class CodeDesign implements iCodeDesign {
		private $input, $output;
		private static $content_folder;
		
		public function __construct() {
			$this->input = "";
			$this->output = "";
		}
		
		public static function Run($json) {
			if (!empty($json)) {
				$self = new CodeDesign(); return $self->Laboratory($json);
			}
		}
		
		private function Laboratory($input) {
			$this->input = json_decode($input, true, 9);
				foreach($this->input as $settings => $options) {
					if ($settings != "config") {
						$this->output .= $this->Library($settings, $options, $this->input["config"])."\n";
					}
				}
				
				if ($this->input["config"]["path"]["folders"]["content"]) {
					self::$content_folder = $this->input["config"]["path"]["folders"]["content"];
				}
	
			echo $this->output;
		}
				
		private function Library($markup, $files, $settings) {
			$options = array(
				"cache" => $settings["cache"],
				"concat" => $settings["concat"],
				"minify" => $settings["minify"]
			);
			$output = "";
			
				switch($markup) {
					case "stylesheet":				
						$options["path"] = $settings["path"]["files"]["css"];
						$output = Library::StylesheetFile($files, $options);
					break;
					case "javascript":
						$options["path"] = $settings["path"]["files"]["js"];
						$output = Library::JavascriptFile($files, $options);
					break;
					default:
					break;
				}
			return $output;
		}
		
		public static function Content($path) {
			$output = "";
			
				if (!empty(self::$content_folder)) {
					Moo::Sandbox(
						$output = Library::Markdown(self::$content_folder.$path)
					);
				} else {
					$output = "Missing Content Folder.";
				}
				
			return $output;
		}
		
	}
	
?>