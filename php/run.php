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
		private static $content_folder;
		
		public static function Run($json) {
			if (!empty($json)) {
				return self::Laboratory($json);
			}
		}
		
		private static function Laboratory($input) {
			$input = json_decode($input, true, 9);
			$output = "";
			
				foreach($input as $settings => $options) {
					if ($settings != "config") {
						$output .= self::Library($settings, $options, $input["config"])."\n";
					}
				}
				
				if ($input["config"]["path"]["folders"]["content"]) {
					self::$content_folder = $input["config"]["path"]["folders"]["content"];
				}
	
			return $output;
		}

		private static function Library($markup, $files, $settings) {
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