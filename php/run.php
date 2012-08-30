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
			$output = array();
			
			if (!empty($json)) {
				$output = self::Laboratory($json);
			} else {
				Moo::Log("Run Failed: No config.json file found", true);
			}
			
			return $output;
		}

		private static function MakeEnv($default, $domain) {
            foreach ($domain as $settings => $options) {
                if ((is_array($options)  && count(array_filter(array_keys($options),'is_string')) == count($options))) {
                    $default[$settings] = array_replace_recursive($default[$settings], $domain[$settings]);
                } else {
                    if (is_array($options)) {
                        $default[$settings] = array_merge($default[$settings], $domain[$settings]);
                    }
                }
            }
            
            return $default;
		}
		
		private static function Config($environment) {
            $output = array();
				foreach($environment as $domain => $settings) {
					if ($domain == "default") {
						$output = $environment["default"];
					} else {
						if (Moo::DomainCheck($domain)) {
							$output = self::MakeEnv($output, $settings);
						}
					}
				}
			
			return $output;
		}
		
		private static function Laboratory($input) {
			$input = self::Config(json_decode($input, true, 9));
			$output = "";
			
				foreach($input as $settings => $options) {
					if ($settings != "config") {
						Moo::Debug($settings);
						$output .= self::Library($settings, $options, $input)."\n";
					}
				}
				
				if ($input["resources"]["folders"]["content"]) {
					self::$content_folder = $input["resources"]["folders"]["content"];
				}
	
			return $output;
		}

		private static function Library($markup, $files, $settings) {
			$options = array(
				"cache" => $settings["config"]["cache"],
				"concat" => $settings["config"]["concat"],
				"minify" => $settings["config"]["minify"]
			);
			$output = "";
			
				switch($markup) {
					case "stylesheet":				
						$options["path"] = $settings["resources"]["files"]["css"];
						$output = Library::StylesheetFile($files, $options);
					break;
					case "javascript":
						$options["path"] = $settings["resources"]["files"]["js"];
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