<!DOCTYPE HTML><html><head>
	<title>FEBuild - </title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	
	<?php require_once(dirname(__FILE__). '/febuild/run.php'); FEBuild::Run('{
		"config": {
			"concat": true,
			"minify": true
		},
		"stylesheet": [
			"style/example.less",
			"style/general.css"
		],
		"javascript": [
			"script/libs/jquery.min.js",
			"script/example.coffee",
			"script/general.js"
		]
	}'); ?>
	
</head><body>
	
	<!-- Page -->
	<div id="page">

	</div>
	
</body></html>