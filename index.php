<!DOCTYPE HTML><html><head>
	<title>FEBuild - </title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	
	<?php require_once(dirname(__FILE__). '/febuild/febuild.class.php'); FEBuild::Run('{
		"config": {
			"environment": 	"develop",
			"concat":		true
		},
		"style": [
			"style/example.less",
			"style/general.css",
			{
				"src": "style/print.css",
				"media": "print"
			}
		],
		"javascript": [
			"script/libs/jquery.min.js",
			"script/example.coffee",
			"script/general.js"
		]
	}'); ?>
	
</head><body>
	
	<!-- Page -->
	<pre id="page">

	</pre>
	
</body></html>