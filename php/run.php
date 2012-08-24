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
		private $input, $output, $settings;
		private static $content_folder;
		
		public function __construct() {
			$this->input = "";
			$this->output = "";
			$this->settings = array(
				"cache"			=> false,
				"concat"		=> false,
				"minify"		=> false,
				"path"			=> array(
					"css"		=> "style/common.css",
					"js"		=> "script/common.js",
					"content"	=> "content/"
				)
			);
		}
		
		public static function Run($json) {
			if (!empty($json)) {
				$self = new CodeDesign(); return $self->Laboratory($json);
			}
		}
		
		private function Laboratory($input) {
			$this->input = json_decode($input, true, 9);
			
				foreach($this->input as $settings => $options) {
					if ($settings == "config") {
						foreach($options as $key => $value) {
							if (!empty($value)) {
								$this->settings[$key] = $value;
							} 
						}
						
						self::$content_folder = $this->settings["path"]["content"];
					} else {
						$this->output .= $this->Library($settings, $options, $this->settings)."\n";
					}
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
						$options["path"] = $settings["path"]["css"];
						$output = Library::StylesheetFile($files, $options);
					break;
					case "javascript":
						$options["path"] = $settings["path"]["js"];
						$output = Library::JavascriptFile($files, $options);
					break;
					default:
					break;
				}
			return $output;
		}
		
		public static function Content($path) {
			return Moo::Sandbox(
				Library::Markdown(self::$content_folder.$path)
			);
		}
		
	}
	
?>